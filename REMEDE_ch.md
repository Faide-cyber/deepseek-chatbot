# deepseek-chatbot

#### [English Doc](https://github.com/Faide-cyber/deepseek-chatbot)

![Static Badge](https://img.shields.io/badge/%40Github-Faide-%2300FFFF) ![Static Badge](https://img.shields.io/badge/PlatForm-Windows-%238c37dc) ![Static Badge](https://img.shields.io/badge/Version-1.0.0-%23e87435) ![Static Badge](https://img.shields.io/badge/License-GNU3.0-%2314bbc1)
### 1. 项目概述

**DeepSeek Chatbot** 是一个基于 DeepSeek V3/R1 聊天模型构建的 WordPress 插件。项目主要面向高校辅导员，提供智能问答、对话历史管理、跨域数据交互以及可定制的前后端配置。插件整体设计注重模块化和安全性，便于后续功能扩展与维护。详见 [示例页面](https://faide.top/model/index.html)。

<img src="https://github.com/Faide-cyber/deepseek-chatbot/blob/main/assets/demo.png" width="600px">

### 2. 系统架构与文件结构

项目主要包含以下几个部分：

```
/index.html
/deepseek-chatbot/
├── deepseek-chatbot.php        // 插件入口文件，负责初始化插件、注册钩子及加载依赖模块
├── assets/
│   ├── style.css               // 聊天窗口及相关前端组件样式定义
│   └── script.js               // 前端交互逻辑，包含历史会话加载及消息发送处理
└── includes/
    ├── admin-settings.php      // 后台管理页面与设置项的实现，含 API Key 与知识库配置
    └── chatbot-frontend.php    // 前台展示及 AJAX 接口实现，负责与 DeepSeek API 的交互
```

各文件职责说明：

- **index.html**：示例页面，展示插件集成效果及基本交互逻辑；便于用户预览前端样式与布局。
- **deepseek-chatbot.php**：插件主文件，包含插件信息、激活钩子和跨域访问配置，确保 API 调用的安全性与数据传输的稳定性。
- **assets/**：存放前端静态资源，确保样式和交互行为独立管理，方便后续调整。
- **includes/**：包含管理设置和前台接口代码，分别实现后台配置页面和用户前端的 AJAX 请求处理。

### 3. 环境要求与依赖

- **WordPress**：确保运行环境为最新稳定版的 WordPress，当前为6.7.2。
- **PHP**：最低支持 PHP 7.2 及以上版本，建议使用最新版本以获得更好的性能与安全性。
- **DeepSeek API**：需申请 DeepSeek API Key，并配置知识库内容，详见 [DeepSeek API 文档](https://api-docs.deepseek.com/zh-cn/api/deepseek-api/)。

### 4. 安装与部署

#### 4.1 下载与安装

1. **获取源码**
    从 GitHub 仓库克隆或下载最新版本源码，并将 `/deepseek-chatbot/` 目录上传至 WordPress 插件目录。
2. **插件激活**
    登录 WordPress 后台，进入【插件】页面，找到 “DeepSeek Chatbot” 插件并点击激活。插件激活时会自动注册相关配置项（如 API Key 和知识库内容）。
3. **示例页面配置**
    将 `/index.html` 文件部署至网站根目录，供预览插件效果及前端交互展示。

#### 4.2 配置

- **API Key 与知识库**
   进入 WordPress 后台【设置】->【DeepSeek Chatbot】页面，配置 DeepSeek API Key 和知识库文本。系统在首次对话时会将知识库内容注入对话历史，确保问答基于指定数据。
- **跨域与安全设置**
   插件在初始化阶段已配置跨域访问头，确保前后端 AJAX 请求安全稳定。建议在生产环境中进一步检查服务器相关安全策略。

### 5. 功能说明

#### 5.1 智能对话系统

- 基于 DeepSeek V3/R1 聊天模型实现问答功能。
- 用户输入消息后，系统将用户信息与预设知识库内容作为上下文发送至 DeepSeek API，返回智能应答结果。
- 对话中包含系统、用户与助手角色信息，通过裁剪策略防止传输数据超限。

#### 5.2 对话历史管理

- 对话历史存储在 WordPress 的 transient 机制中，支持加载、显示及局部裁剪历史记录。
- 系统在每次会话开始时注入系统指令，保证知识库内容始终处于对话上下文中。

#### 5.3 前后端分离设计

- 前端采用响应式设计，使用 jQuery 管理交互与 AJAX 调用，确保多终端适配。
- 后端采用 WordPress AJAX 钩子处理请求，实现数据安全验证、消息转发及历史记录管理。

### 6. 开发与扩展

- **模块化设计**：项目将前端样式、交互逻辑及后端处理分离，便于后续模块扩展和功能定制。
- **可扩展接口**：通过 WordPress 的钩子系统和 AJAX 接口，开发者可在不修改核心代码的前提下，扩展或替换现有功能。
- **安全策略**：用户输入经过严格过滤，避免 XSS、SQL 注入等常见安全风险。跨域设置确保接口调用符合安全策略。

### 7. 许可

您可以根据自由软件基金会发布的GNU通用公共许可证的条款进行再分发和/或修改。您可以选择使用第3版许可证，或者任何更高版本的许可证。

本程序是以希望它会有用的方式发布，但不提供任何明示或暗示的保证，包括但不限于适销性或特定用途的适用性。请参阅GNU通用公共许可证以获取更多详细信息。

您应该已经随此程序收到了GNU通用公共许可证的副本。如果没有，请参阅http://www.gnu.org/licenses/。


### 8. 免责声明

**DeepSeek Chatbot**（以下简称“本项目”）（以下简称“本项目”）仅供学习和研究使用，禁止将其用于任何非法用途。如果您选择使用本项目的任何部分，您必须遵守所有相关法律和规定，并承担由此产生的所有责任。

作者不对因使用本项目而导致的任何损失或损害负责。如果您选择使用本项目的任何部分，您应该自己承担所有风险和责任。

本人保留追究任何非法使用本项目的人的法律责任的权利。如果您选择使用本项目的任何部分进行非法活动，您将面临法律诉讼和其他惩罚。

使用者应遵守相关法律法规，尊重作者的知识产权。任何因违反上述规定而引起的法律纠纷，由使用者承担全部责任。

本声明的解释权归作者所有。

### 9. 附加信息

- **最新源码与文档**
   请访问 GitHub 仓库获取最新的源码及文档更新：https://github.com/Faide-cyber/
- **DeepSeek API 相关文档**
   详见 [DeepSeek API 文档](https://api-docs.deepseek.com/zh-cn/api/deepseek-api/)

### 10. 联系方式

微信或邮箱1350038426@qq.com

如果您有任何问题或疑问，也可以通过提交issue的方式与我进行交流。

在提交issue时，请确保描述清楚您的问题或反馈，并提供足够的上下文信息，以便我能够更好地理解和回答您的问题。

![QQ图片202310251908231](https://github.com/Faide-cyber/MouseCopy/assets/148406475/8b7ac122-d438-4d64-b6d0-330b514e4389)
