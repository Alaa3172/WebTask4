# WebTask4
## Description
This project is a simple speech-to-text web application that supports both Arabic and English languages. It allows users to start and stop recording their speech, and it saves the transcribed text to a MySQL database. 

## Features 
* __Language Selection:__ Choose between English and Arabic for speech recognition.
* __Start/Stop Recording:__ Manually control the recording process.
* __Live Transcript Display:__ View the transcribed text in real-time.
* __Database Integration:__ Save the transcribed text to a MySQL database.
* __Error Handling:__ Feedback on whether the transcript was saved successfully or if there were errors.

## Prerequisites
* XAMPP (includes Apache server and MySQL database)
* Visual Studio Code or any other code editor
* Web browser (e.g., Chrome, Firefox)

## Setup 
1. __Download the project folder "speech_to_text" from the repository.__
2. __Setup XAMPP__
- Start the XAMPP Control Panel and ensure both Apache and MySQL are running.

  <img width="498" alt="image" src="https://github.com/Alaa3172/WebTask1/assets/173661540/6ce74776-3b03-4911-877a-6f4a0b9a5aa9">

3. __Move Project Files__
- Copy the downloaded project folder __"speech_to_text"__ to the htdocs directory in your XAMPP installation. The default path is C:\xampp\htdocs\ on Windows or /Applications/XAMPP/htdocs/ on macOS.

  ![image](https://github.com/user-attachments/assets/b2ec02e0-9690-4d19-a92c-6932f5115b88)

4. __Create the Database__
- Open your web browser and go to http://localhost/phpmyadmin.

  ![image](https://github.com/user-attachments/assets/38af8549-9728-4404-9f43-93459351d445)

- Create a new database named __'speech_to_text'__.

  ![image](https://github.com/user-attachments/assets/f8492c47-3c92-4248-9a18-8d462b85b5d0)

- Create a table named __'transcripts'__ with the following structure:
  - id (INT, 11)
  - text (TEXT)

  ![image](https://github.com/user-attachments/assets/61a3ea05-35b9-43c6-aa1a-02f16268fd10)

5. __Configure PHP Files__
- Open __'save_to_database.php'__ in your code editor.
- Ensure the database connection details (host, username, password, database name) are correct.

  ![image](https://github.com/user-attachments/assets/4786a519-c38f-4483-9b83-d8d06d595b47)

## Usage
1. __Open the Webpage:__
- Navigate to webpage.php in your browser.
2. __Select a Language:__
- Click the "English" or "Arabic" button to set the language for speech recognition.
3. __Start Recording:__
- Click the "Start Recording" button to begin speech recognition.
4. __Stop Recording:__
- Click the "Stop Recording" button to stop the recognition process. The transcribed text will be displayed and saved to the database.
5. __View Status:__
- Check the status message below the buttons for feedback on whether the transcript was saved successfully.

## File Structure
- __webpage.php__ - Contains HTML, CSS, and JavaScript for the webpage.
- __save_to_database.php__ - PHP script that saves the transcribed text to the database.

## Screenshots
![image](https://github.com/user-attachments/assets/7de3f469-c727-4671-84ed-5e556ad23fa9)

Figure 1: Main interface with language selection buttons, start and stop recording buttons, live transcript display, and status message area.

![image](https://github.com/user-attachments/assets/af13d599-bacb-4848-b2af-88118dd756c0)

Figure 2: Database table structure and recorded text.

## Code Explanation
__HTML Code:__
```
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
```

Meta tags for character set and title, and internal CSS for styling the page and buttons.

```
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
</body>
```

HTML structure with buttons for language selection and recording control, and divs to display the transcript and status.

```
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
```

JavaScript to initialize the page once DOM content is loaded, including speech recognition setup.

```
        langButtons.forEach(button => {
            button.addEventListener('click', () => {
                language = button.id === 'lang-en' ? 'en' : 'ar';
                recognition.lang = language === 'en' ? 'en-US' : 'ar-SA';
                startButton.disabled = false;
                statusDiv.textContent = `Language set to ${language === 'en' ? 'English' : 'Arabic'}`;
                statusDiv.style.color = 'blue';
            });
        });
```

JavaScript to handle language selection and update recognition language and status message.

```
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
```

JavaScript to start and stop the speech recognition, updating button states and status messages.

```
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
```

JavaScript to handle speech recognition results, display the transcript, and send it to the server via an AJAX request.

```
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
```

JavaScript for handling errors in the speech recognition process and restarting recognition if stopped unexpectedly.

__PHP Code:__
```
<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "speech_to_text";
```

Establishes connection parameters for the MySQL database.

```
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
```

Creates a new MySQLi connection and checks for connection errors, terminating the script if a connection fails.

```
$transcript = $_POST['transcript'];

$sql = "INSERT INTO transcripts (text) VALUES (?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
```

Retrieves the transcript from the POST request, prepares the SQL statement for insertion, and checks for errors in the preparation stage.

```
$stmt->bind_param("s", $transcript);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}
```

Binds the transcript parameter to the SQL statement, executes it, and outputs a success message if successful or an error message if not.

```
$stmt->close();
$conn->close();
?>
```

Closes the prepared statement and the database connection.
