# Jivo Live Chat Setup Guide

## Overview
Jivo live chat has been integrated into the B-Family Homes website. The chat widget will appear on all public pages automatically.

## Setup Instructions

### Step 1: Get Your Jivo Widget ID
1. Sign up for a free account at [https://www.jivochat.com/](https://www.jivochat.com/)
2. After logging in, go to your Jivo dashboard
3. Navigate to **Settings** → **Widget** → **Installation**
4. Copy your **Widget ID** (it's usually a string like `abc123def456`)

### Step 2: Add Widget ID to Environment
1. Open your `.env` file in the project root
2. Add the following line:
   ```
   JIVO_WIDGET_ID=your_widget_id_here
   ```
3. Replace `your_widget_id_here` with your actual Jivo widget ID

### Step 3: Clear Config Cache (if needed)
If you're in production, run:
```bash
php artisan config:clear
```

## How It Works

- The Jivo chat widget will automatically appear on all pages using the `app.blade.php` layout
- The widget is conditionally loaded - it only appears if `JIVO_WIDGET_ID` is set in your `.env` file
- The chat button will appear in the bottom-right corner of the page (alongside the WhatsApp button)
- Visitors can click the chat button to start a conversation with your support team

## Configuration

The Jivo widget ID is stored in:
- **Config file**: `config/bfamily.php`
- **Environment variable**: `JIVO_WIDGET_ID`

## Customization

You can customize the Jivo chat widget appearance and behavior directly from your Jivo dashboard:
- Chat button color and position
- Welcome messages
- Operating hours
- Auto-responses
- And much more

## Support

For Jivo-specific issues, visit: [https://www.jivochat.com/support/](https://www.jivochat.com/support/)

