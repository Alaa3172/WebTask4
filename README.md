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



