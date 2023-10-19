## LAMP-based Course Project with Secure Authentication System

This is a course project built on the LAMP (Linux, Apache, MySQL, PHP) stack, featuring a secure authentication system (CAPTCHA).

Please wait while the GIF demonstrating the loading process loads on this page :)
![Header](https://github.com/smaugcow/smaugcow/blob/main/assets/fb.gif)

### Project Milestones:

1. Architectural System Design.
2. Creation of a Web Interface.
3. Implementation of a Client Recognition System (Turing Test).
4. Backend Development in PHP.
5. System Testing.

For Turing Test functionality, an additional PHP library named GD Graphics Library is required. Depending on your platform, follow these steps:

**On Windows (XAMPP):**

Uncomment the following line in the php.ini file:
```ini
;extension=gd -> extension=gd
```

**On Linux (Ubuntu) for PHP 8.2:**

Install the PHP GD package:
```bash
sudo apt install php8.2-gd
```

### Server Features:

The server offers the following functionality:

1. User Registration with Turing Test Verification (user passwords are stored in hashed form).
2. Account Login with Captcha Verification.
3. Product Management: Addition, Deletion, and Name Modification.
4. Sorting of Cart Items by ID and Name.
5. Item Highlighting for Specificity.

### Technology Stack:

I employed the following technologies for this project:

![PHP](https://img.shields.io/badge/-PHP8.2-090909?style=for-the-badge&logo=PHP&logoColor=097CDB)
![PHP GD](https://img.shields.io/badge/-PHP8.2_GD-090909?style=for-the-badge&logo=PHP&logoColor=097CDB)
![JavaScript](https://img.shields.io/badge/-JavaScript-090909?style=for-the-badge&logo=JavaScript&logoColor=cddb09)
![CSS](https://img.shields.io/badge/-CSS-090909?style=for-the-badge&logo=CSS&logoColor=cddb09)
![Apache/2.4.52](https://img.shields.io/badge/-Apache/2.4.52-090909?style=for-the-badge&logo=Apache&logoColor=db1009)
![Linux](https://img.shields.io/badge/-Linux-090909?style=for-the-badge&logo=Linux&logoColor=ffffff)
