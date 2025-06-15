<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
    }

    #chatbox {
        height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 15px;
        background: #ffffff;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .chat-message {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 8px;
        display: inline-block;
        max-width: 80%;
        word-wrap: break-word;
    }

    .user-message {
        background-color: #007bff;
        color: white;
        float: right;
        clear: both;
        margin-left: auto;
        margin-right: 0;
    }

    .bot-message {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #e9ecef;
        float: left;
        clear: both;
        margin-left: 0;
        margin-right: auto;
    }

    .message-container {
        width: 100%;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .chat-input-container {
        display: flex;
        gap: 10px;
    }

    #userInput {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .send-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .send-btn:hover {
        background-color: #0056b3;
    }

    .nav-list li.active {
        background-color: #0088cc !important;
        border-radius: 5px;
    }

    .nav-list li.active a {
        color: white !important;
        font-weight: bold;
    }

    .nav-list li.active a i {
        color: white !important;
    }
</style>

<body id="class_div">
<div class="wrapper">

    <?php include('navbar_teacher.php'); ?>

    <div class="container-fluid main-content">
        <div class="row-fluid">
            <?php 
            $active_page = 'chatbot';
            include('teacher_sidebar.php'); 
            ?>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li><a href="#"><b>Chatbot</b></a><span class="divider">/</span></li>
                        <li><a href="#">EduFun Assistant</a></li>
                    </ul>
                    <!-- end breadcrumb -->

                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">
                                <i class="icon-comment"></i> EduFun Chatbot
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div id="chatbox"></div>
                                <div class="chat-input-container">
                                    <input type="text" id="userInput" class="form-control" placeholder="Ask anything about EduFun..." onkeypress="handleKeyPress(event)">
                                    <button class="send-btn" onclick="sendMessage()">
                                        <i class="icon-paper-plane"></i> Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
            </div>
        </div>
    </div> 

    <?php include('footer.php'); ?> 

</div> 

<script type="text/javascript">
async function sendMessage(message = null) {
    const inputField = document.getElementById("userInput");
    const chatbox = document.getElementById("chatbox");

    const userMessage = message || inputField.value.trim();
    if (!userMessage) return;

    if (!message) {
        // Display user message
        chatbox.innerHTML += `
            <div class="message-container">
                <div class="chat-message user-message"><strong>You:</strong> ${userMessage}</div>
            </div>`;
        inputField.value = "";
    }

    // Auto scroll to bottom
    chatbox.scrollTop = chatbox.scrollHeight;

    try {
        const response = await fetch("teacher_ask_gemini.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ question: userMessage })
        });

        const data = await response.json();
        const botMessage = data.response || "Maaf, terjadi kesalahan pada server.";

        // Display bot message
        chatbox.innerHTML += `
            <div class="message-container">
                <div class="chat-message bot-message"><strong>EduFun Bot:</strong> ${botMessage}</div>
            </div>`;
        chatbox.scrollTop = chatbox.scrollHeight;
    } catch (error) {
        chatbox.innerHTML += `
            <div class="message-container">
                <div class="chat-message bot-message"><strong>EduFun Bot:</strong> An error occurred while contacting the server.</div>
            </div>`;
        chatbox.scrollTop = chatbox.scrollHeight;
    }
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Initialize chatbot when page loads
window.onload = function() {
    // Aktifkan menu chatbot
    const chatbotMenu = document.querySelector('a[href*="chatbot"]');
    if (chatbotMenu) {
        chatbotMenu.parentElement.classList.add('active');
    }
    
    // Hapus class active dari menu lain
    const allMenus = document.querySelectorAll('.nav-list li');
    allMenus.forEach(menu => {
        if (!menu.querySelector('a[href*="chatbot"]')) {
            menu.classList.remove('active');
        }
    });

    setTimeout(function() {
        sendMessage("Introduce yourself as EduFun chatbot and ask how you can help..");
    }, 500);
};
</script>

<?php include('script.php'); ?>
</body>
</html>