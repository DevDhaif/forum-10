In this chapter, the proposed method implementation is described, starting with the hardware and  software setup used to build the code, simulate, and test the environment. The code is divided  into several sections: network, devices, servers, attacks, and detection. 

The devices section deals with the configuration and integration of the hardware devices required for the system. This may include sensors, actuators, and other components necessary for data collection and interaction with the environment. the proposed method. 

The chapter also includes a discussion of the support method and user behavior detection, along with an evaluation of the method's strengths and weaknesses using appropriate metrics. 

The chapter has six main sections that detail each step in the implementation process. The attacks section is dedicated to simulating various types of attacks that the system may encounter. This helps in testing the system's resilience and identifying potential vulnerabilities. It involves implementing different attack scenarios and evaluating the system's response to these attacks.

By dividing the code into these sections, the proposed method implementation aims to provide a structured and comprehensive approach to building a secure and robust system. Each section plays a vital role in ensuring the system's functionality, security, and resilience. 

Overall, this chapter serves as a detailed guide to implementing the proposed method, enabling researchers and developers to replicate and further improve upon the system.




4.2 Experimental Setup

The following section will provide detailed explanation about the phases of the experiment to implement the proposed approach.

4.2.1 Hardware and Software requirement

The simulation of the proposed approach allows for Simulate the user login process and two-factor verification process with different configurations such as type of traffic, security keys (Encryption Keys) and  passwords, latency, packet rate, and power consumption. This simulation allows for Simulate the user Authentication process on mobile application  in the network . There are many types of simulation that can be used, but the proposed method  uses a special simulation designed to meet the needs of the model and support the coding and classification stages. The simulation  were built using C#. The process of sending the verification code was simulated using Twilio Server SMS Provider.
  

4.2.2 User registration

The user enters their username and password on the login screen of application. When the user enters their username and password on the login screen of the application, the system initiates the authentication process. First, the entered username is validated to ensure it exists in the system's database. If the username is valid, the system retrieves the corresponding password associated with that username.Next, the system securely compares the entered password with the stored password using a hashing algorithm. This ensures that even if the system's database is compromised, the actual passwords remain protected. If the entered password matches the stored password, the user is granted access to the application

4.2.2.1 Generating an OTP


begins by importing the necessary modules. random module is imported to generate random numbers, and twilio.rest is imported to interact with the Twilio API. Next, a function called generate_otp() is defined. This function generates a 3-digit OTP (One-Time Password) by randomly selecting digits from the string "0123456789". The random.choice() function is used to select a random digit, and the loop runs three times to generate a three-digit OTP. The generated OTP is stored in the otp variable and then returned. The following cod shows the steps of OTP generating  process.
the random module is imported to generate random numbers, and the twilio.rest module is imported to interact with the Twilio API. The Client class from the twilio.rest module allows communication with the Twilio service.
The generate_otp() function is defined to generate a 3-digit OTP. Within the function.  The digits variable contains the string "0123456789", which represents all the possible digits for the OTP. he otp variable is initially an empty string he for loop runs three times using range(3). In each iteration The random. Choice  (digits) function selects a random digit from the digits string. The selected digit is then appended to the otp variable using the += operator. After three iterations, the function returns the generated OTP using the return statement. The code provided focuses on generating a random OTP. However, it does not include any code related to interacting with the Twilio API or sending the OTP to a user's phone. To send the OTP via SMS using Twilio, you would need to use the Client class and its methods provided by the Twilio API. This would involve setting up a Twilio account, obtaining the necessary credentials (account SID and auth token), and using the Twilio API to send an SMS message containing the generated OTP.






Figure 1: OTP generating code







4.2.2.2 send the SMS message

send the SMS message. It takes several parameters:body contains the content of the message, including the OTP generated earlier,from is the sender's phone number (your Twilio phone number),to is the recipient's phone number
To send the SMS message using the Twilio API, you would utilize the Client class and its methods. One such method is messages.create(), which allows you to send an SMS message. This method requires several parameters:
body: This parameter contains the content of the message, including the OTP generated earlier. You would pass the OTP as a string to the body parameter.
from_: This parameter represents the sender's phone number, which should be your Twilio phone number. You need to provide your Twilio phone number as a string to the from_ parameter.
to: This parameter represents the recipient's phone number, to whom you want to send the OTP. You would provide the recipient's phone number as a string to the to parameter.
.

4.2.3 Simulation Environment

The Console.Write method is used to display the message "Enter the recipient's phone number (+country code): " to the console, providing instructions to the user. After displaying the message, the code waits for the user to enter the phone number. The Console.ReadLine method is used to read the user's input as a string. It will wait for the user to enter the phone number and press the Enter key.
Once the user presses Enter, the entered phone number is captured and stored in the phoneNumber variable, which is declared as a string



Figure 2: Generate random letters cod 





4.2.3.1 Combine verification code and random characters

enerateRandomLetters method, passing 3 as an argument. The method generates a string of three random letters and assigns it to  creates a message string by concatenating the verification code and the random letters generated in the previous step. The $ symbol denotes an interpolated string, allowing variables (verificationCode and randomLetters) to be directly embedded within the string.the randomLetters variable.
a


Figure 3: Combine verification code

4.2.3.2 authentication process

The verification code and random letters are then concatenated using an interpolated string. The resulting message is stored in the message variable in the format "Your verification code is [verificationCode][randomLetters]. The code then attempts to send the SMS message using the MessageResource.Create method from the Twilio API. The body parameter of the method is set to the message string, the from parameter is set to the Twilio phone number, and the to parameter is set to the recipient's phone number. If the SMS is sent successfully, the SID (unique identifier) of the sent message is printed to the console. In case any exception occurs during the process, such as a failure to send the SMS, the code catches the exception and prints an error message to the console. Overall, this code segment combines user input, random letter generation, and Twilio integration to send an SMS message with a verification code to the specified phone number.





Figure 4: Authentication cod 
	

4.7 Summary


In this chapter, we will present the results of the proposed method based on its implementation and approach. We will use different rating metrics to evaluate the method's performance for different attack scenarios. These scenarios are designed to test the effectiveness of the method in protecting and ensuring data integrity, confidentiality, availability and usability for users and servers. The results will also include an analysis of the impact of the devices Network attacks on system performance and power consumption.

