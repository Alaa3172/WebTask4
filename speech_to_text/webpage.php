<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Speech-to-Text</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
            background-color: #f7f7f7;
        }
        h2 {
            color: #333;
        }
        button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007aff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        button:disabled {
            background-color: #a7a7a7;
        }
        #output, #status {
            margin-top: 20px;
            padding: 10px;
            font-size: 16px;
            color: #333;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <h2>Speech-to-Text</h2>
    <div>
        <button id="lang-en">English</button>
        <button id="lang-ar">Arabic</button>
    </div>
    <button id="start-recognition" disabled>Start Recording</button>
    <button id="stop-recognition" disabled>Stop Recording</button>
    <div id="output">Transcript will appear here...</div>
    <div id="status"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const langButtons = document.querySelectorAll('button[id^="lang-"]');
            const startButton = document.getElementById('start-recognition');
            const stopButton = document.getElementById('stop-recognition');
            const outputDiv = document.getElementById('output');
            const statusDiv = document.getElementById('status');
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.interimResults = false;

            let language = 'en'; // Default to English

            langButtons.forEach(button => {
                button.addEventListener('click', () => {
                    language = button.id === 'lang-en' ? 'en' : 'ar';
                    recognition.lang = language === 'en' ? 'en-US' : 'ar-SA';
                    startButton.disabled = false;
                    statusDiv.textContent = `Language set to ${language === 'en' ? 'English' : 'Arabic'}`;
                    statusDiv.style.color = 'blue';
                });
            });

            startButton.addEventListener('click', () => {
                recognition.start();
                startButton.disabled = true;
                stopButton.disabled = false;
                statusDiv.textContent = 'Recording...';
                statusDiv.style.color = 'blue';
            });

            stopButton.addEventListener('click', () => {
                recognition.stop();
                startButton.disabled = false;
                stopButton.disabled = true;
                statusDiv.textContent = 'Stopped recording.';
                statusDiv.style.color = 'blue';
            });

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                outputDiv.textContent = transcript;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_to_database.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        statusDiv.textContent = 'Transcript saved successfully';
                        statusDiv.style.color = 'green';
                    } else {
                        statusDiv.textContent = 'Error saving transcript: ' + xhr.statusText;
                        statusDiv.style.color = 'red';
                    }
                };
                xhr.onerror = function() {
                    statusDiv.textContent = 'Request error';
                    statusDiv.style.color = 'red';
                };
                xhr.send('transcript=' + encodeURIComponent(transcript) + '&language=' + encodeURIComponent(language));
            };

            recognition.onerror = (event) => {
                console.error('Error occurred in recognition: ' + event.error);
                startButton.disabled = false;
                stopButton.disabled = true;
                statusDiv.textContent = 'Recognition error: ' + event.error;
                statusDiv.style.color = 'red';
            };

            recognition.onend = () => {
                if (stopButton.disabled === false) {
                    recognition.start();
                }
            };
        });
    </script>
</body>
</html>
