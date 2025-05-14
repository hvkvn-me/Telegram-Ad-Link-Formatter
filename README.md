# Telegram-Ad-Link-Formatter
A simple and efficient Telegram bot that formats and organizes your advertisement channel links by removing duplicates and adding neat numbering. Perfect for marketers and channel admins to manage promo links effortlessly.

---

## Features

- Handles `/start` and `/help` commands with friendly responses.
- Accepts channel usernames or Telegram links in various formats.
- Removes duplicates regardless of input style.
- Outputs a numbered list of unique usernames.
- Waits for new input after processing each list.

---

## Setup & Usage

1. Get your **Telegram Bot API token** from [BotFather](https://t.me/BotFather).
2. Upload `bot.php` to a PHP-enabled server with HTTPS.
3. Set up a webhook so Telegram can send updates to your bot:
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://yourdomain.com/path/to/bot.php
4. Start a chat with your bot and send `/start` or `/help`.
5. Send your list of Telegram channel links or usernames.
6. Receive a clean, numbered, duplicate-free list in response.

---

## Example

**Input:**

1 - https://t.me/example1 /
2 - @example2 /
@example1 /
https://t.me/example3

**Output:**
1. @example1
2. @example2
3. @example3
   
---

## Notes

- Only valid Telegram usernames or links accepted.
- Non-link messages or unrelated commands are ignored.
- Designed to work with a specific chat ID for security.

---

## License

Open source — free to use and modify.

---

*Made with ❤️ for Telegram marketers.*
