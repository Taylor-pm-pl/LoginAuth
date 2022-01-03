[![](https://poggit.pmmp.io/shield.state/LoginAuth)]
<div align="center">
<h1>LoginAuth| v0.0.1<h1>
<p>Protect member's account</p>
</div>

## Features
- Protect member's account
- Easy to set up
 
## All LoginAuth Commands:

| **Command** | **Description** |
| --- | --- |
| **/login** | **Command to login to the server** |
| **/register** | **Command to register to the server** |
| **/changepassword** | **Command to change password** |
 
# Config
```yaml
---
#  _                _          _         _   _     
# | |    ___   __ _(_)_ __    / \  _   _| |_| |__  
# | |   / _ \ / _` | | '_ \  / _ \| | | | __| '_ \ 
# | |__| (_) | (_| | | | | |/ ___ \ |_| | |_| | | |
# |_____\___/ \__, |_|_| |_/_/   \_\__,_|\__|_| |_|
#             |___/                  
# Config Main of LoginAuth
# Please do not edit this section!             
config-version: 0.0.1

# Here is the edit description for the command!
description:
  login: "Command to login to the server"
  register: "Command to register to the server"
  changepassword: "Command to change password"

# Here is the message editing
error:
  useingame: "&cPlease use this command in-game"

# This is the message for the login command
login:
  usage: "&cUsage: /login (password) to login!"
  account-not-exists: "&cYou need to register for an account first!"
  password-wrong: "&cThe login password you just entered is wrong!"
  success: "&aSuccessful login!"

# This is the message for the register command
register:
  usage: "&cUsage: /register (password) (password confirm) to register!"
  account-exists: "&cYou have an account already!"
  confirm-wrong: "&cThe account registration confirmation password is different from the first password"
  success: "&aYou have successfully registered an account!" 

# This is the message for the changepassword command
changepassword:
  usage: "&cUsage: /changepassword (password new) (password confirm) to changepassword"
  error: "&cThe confirmation password must be the same as the new password you just entered!"
  success: "&aYou have successfully changed your password!"
...
```

# Contacts
**You can contact me directly through the platforms listed below**
| Platform | NhanAZ             |
| :------: | :----------------: |
| Discord  | Jero Gaming#6805        |
| Email    | JeroGamingYT@pm.me       |

## Project Infomation

| Plugin Version | Pocketmine API | PHP Version | Plugin Status |
|---|---|---|---|
| 0.0.1 | 4.x.x | 8.0 | Completed |
 
