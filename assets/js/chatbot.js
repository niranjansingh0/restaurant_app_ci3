function sendMessage() {
	const input = document.getElementById("userMessage");
	const msg = input.value.trim();

	if (!msg) return;

	addMessage(msg, "user");
	input.value = "";

	// show typing indicator
	addMessage("Typing...", "bot");

	// Get base URL from the page (set by PHP in the view)
	let baseUrl = document.querySelector("body").getAttribute("data-base-url");
	if (!baseUrl) {
		baseUrl = window.location.origin + "/restaurant_app_ci3/";
	}

	const apiUrl = baseUrl + "api/chatbot";
	console.log("📤 Calling API: " + apiUrl);

	fetch(apiUrl, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ message: msg }),
	})
		.then((res) => {
			console.log("📥 Response Status: " + res.status);
			if (!res.ok) {
				throw new Error("HTTP Error " + res.status + " - " + res.statusText);
			}
			return res.json();
		})
		.then((data) => {
			console.log("✅ API Response:", data);
			removeTyping();
			if (data.reply) {
				addMessage(data.reply, "bot");
			} else {
				addMessage("No reply received from AI.", "bot");
			}
		})
		.catch((err) => {
			removeTyping();
			console.error("❌ Chatbot Error:", err);
			addMessage(
				"Error: " + err.message + " (Check console for details)",
				"bot",
			);
		});
}

function addMessage(text, type) {
	const chat = document.getElementById("chatMessages");
	const div = document.createElement("div");
	div.className = type === "user" ? "msg-user" : "msg-bot";
	div.textContent = text;
	chat.appendChild(div);
	chat.scrollTop = chat.scrollHeight;
}

function removeTyping() {
	const chat = document.getElementById("chatMessages");
	const messages = chat.querySelectorAll(".msg-bot");
	if (
		messages.length > 0 &&
		messages[messages.length - 1].innerText === "Typing..."
	) {
		messages[messages.length - 1].remove();
	}
}

function toggleChat() {
	const chatbot = document.getElementById("chatbot");
	const toggle = document.getElementById("chatToggle");

	chatbot.classList.toggle("minimized");

	toggle.innerText = chatbot.classList.contains("minimized") ? "▲" : "▼";
}
