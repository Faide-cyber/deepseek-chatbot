# deepseek-chatbot

#### [简体中文文档](https://github.com/Faide-cyber/deepseek-chatbot/blob/main/REMEDE_ch.md)

![Static Badge](https://img.shields.io/badge/%40Github-Faide-%2300FFFF) ![Static Badge](https://img.shields.io/badge/PlatForm-Windows-%238c37dc) ![Static Badge](https://img.shields.io/badge/Version-1.0.0-%23e87435) ![Static Badge](https://img.shields.io/badge/License-GNU3.0-%2314bbc1)
### 1. Project overview

**DeepSeek Chatbot** is a WordPress plugin built on the DeepSeek V3/R1 chat model. The project is mainly aimed at college counselors, providing intelligent questions and answers, conversation history management, cross-domain data interaction, and customizable front - and back-end configurations. The overall design of the plug-in focuses on modularity and security, which is convenient for subsequent function expansion and maintenance. See the sample [page](https://faide.top/model/index.html).

<img src="https://github.com/Faide-cyber/deepseek-chatbot/blob/main/assets/demo.png" width="600px">

### 2. System architecture and file structure

The project mainly includes the following parts:

```
/index.html
/deepseek-chatbot/
├── deepseek-chatbot.php        // plugin entry file, responsible for initializing the plugin, registering hooks and loading dependent modules
├── assets/
│   ├── style.css               // style definition of chat window and related front-end components
│   └── script.js               // Front-end interaction logic, including historical session loading and message sending processing
└── includes/
    ├── admin-settings.php      // Implementation of background management pages and Settings, including API Key and knowledge base configuration
    └── chatbot-frontend.php    // Foreground presentation and AJAX interface implementation, responsible for interaction with the DeepSeek API
```

Description of each document:

- **index.html** : Sample page, showing plug-in integration effects and basic interaction logic; Allows users to preview front-end styles and layouts.
- **deepseek-chatbot.php** : The plugin master file contains the plugin information, activation hooks, and cross-domain access configuration to ensure the security of API calls and the stability of data transfer.
- **assets/** : Store front-end static resources to ensure independent management of styles and interactive behaviors, facilitating subsequent adjustment.
- **includes/** : Includes management Settings and front-end interface code, respectively, to implement the background configuration page and user front-end AJAX request processing.

### 3. Environmental requirements and dependencies

- **WordPress** : Make sure you are running the latest stable version of WordPress, which is currently 6.7.2.
- **PHP** : At least PHP 7.2 or later is supported. The latest version is recommended for better performance and security.
- **DeepSeek API** : Apply for the DeepSeek API Key and configure the knowledge base. For details, see  [DeepSeek API Document](https://api-docs.deepseek.com/api/deepseek-api/).

### 4. Installation and deployment

#### 4.1 Download and Installation

1. **Get the source code**
    Clone or download the latest version of the source code from the GitHub repository and upload the  `/deepseek-chatbot/` directory to the WordPress plugins directory.
2. **Plug-in activation**
    Log in to the WordPress background, go to the "Plugin" page, find the "DeepSeek Chatbot" plugin and click to activate it. The relevant configuration items (such as API keys and knowledge base contents) are automatically registered when the plug-in is activated.
3. **Sample page configuration**
    Deploy the  `/index.html ` file to the root directory of the website for preview of plug-in effects and front-end interactive display.

#### 4.2 Configuration

- **API Key and Knowledge Base**
   Enter the "Settings" -> "DeepSeek Chatbot" page of the WordPress background, and configure the DeepSeek API Key and knowledge base text. The system injects the knowledge base content into the conversation history during the first conversation, ensuring that the Q&A is based on the specified data.
- **Cross-domain with security Settings**
   The plug-in is configured with cross-domain access headers during initialization to ensure the security and stability of front - and back-end AJAX requests. You are advised to further check security policies related to servers in a production environment.

### 5. Function description

#### 5.1 Intelligent Dialog system

- Q&A function based on DeepSeek V3/R1 chat model.
- After the user enters the message, the system sends the user information and the preset knowledge base content as context to the DeepSeek API, and returns the intelligent response result.
- The dialog contains information about the system, users, and assistant roles. Tailoring policies are used to prevent data from being transmitted beyond the limit.

#### 5.2 Managing Chat History

- The conversation history is stored in WordPress 'transient mechanism, which supports loading, displaying, and partially cropping the history.
- The system injects system instructions at the beginning of each session to ensure that the contents of the knowledge base are always in the context of the session.

#### 5.3 Separate the front and rear ends

- The front-end adopts responsive design, and uses jQuery to manage interaction and AJAX calls to ensure multi-terminal adaptation.
- The backend uses WordPress AJAX hooks to process requests for data security verification, message forwarding and history management.

### 6. Development and expansion

- **Modular design** : The project separates the front-end style, interaction logic and back-end processing to facilitate subsequent module expansion and function customization.
- **Extensible interface** : With WordPress's hook system and AJAX interface, developers can extend or replace existing features without modifying the core code.
- **Security Policy** : User input is strictly filtered to avoid common security risks such as XSS and SQL injection. Cross-domain Settings ensure that interface calls comply with security policies.

### 7. Permission

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.


### 8. Disclaimer

**DeepSeek Chatbot** (hereinafter referred to as the "Project") is for study and research use only, and its use for any illegal purpose is prohibited. If you choose to use any part of this Program, you must comply with all applicable laws and regulations and assume all responsibilities arising therefrom.

The author is not responsible for any loss or damage arising from the use of this project. If you choose to use any part of this Project, you do so at your own risk and responsibility.

I reserve the right to take legal responsibility against anyone who illegally uses this project. If you choose to use any part of this program for illegal activities, you will face legal action and other penalties.

Users shall abide by relevant laws and regulations and respect the intellectual property rights of authors. Any legal disputes arising from violation of the above provisions shall be borne by the user.

The author reserves the right to interpret this statement.

### 9. Additional information

- **Latest source code and documentation**
   Visit the GitHub repository for the latest source code and documentation updates: https://github.com/Faide-cyber/
- **DeepSeek API related documentation**
   See [DeepSeek API Documentation](https://api-docs.deepseek.com/api/deepseek-api/)

### 10. Contact information

Wechat or email 1350038426@qq.com

If you have any questions or concerns, you can also communicate with me by submitting an issue.

When submitting an issue, please make sure to describe your problem or feedback clearly and provide enough context information so that I can better understand and answer your question.

![QQ图片202310251908231](https://github.com/Faide-cyber/MouseCopy/assets/148406475/8b7ac122-d438-4d64-b6d0-330b514e4389)
