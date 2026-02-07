# PlayQuizNow for WordPress

Embed interactive quizzes from [PlayQuizNow](https://playquiznow.com) into your WordPress site with a simple shortcode or the Gutenberg block editor.

---

## Features

- **Shortcode & Gutenberg block** — embed quizzes anywhere on your site
- **Auto-resize** — iframe height adjusts automatically via postMessage, no scrollbars
- **Light & Dark themes** — match your site's look
- **Lazy loading** — iframes load on scroll for better page speed
- **Google Analytics tracking** — `quiz_complete` event fires automatically if gtag.js is present
- **Configurable defaults** — set width, height, branding, and lazy load from the admin panel
- **Secure** — sandboxed iframes, strict input validation, origin-checked postMessage

---

## Requirements

| Requirement | Version |
|-------------|---------|
| WordPress   | 5.8+    |
| PHP         | 7.4+    |

---

## Installation

### From ZIP (recommended)

1. Download `playquiznow.zip` from the [latest release](https://github.com/varungulati/playquiznow-wordpress/releases)
2. In your WordPress admin, go to **Plugins → Add New → Upload Plugin**
3. Choose the zip file and click **Install Now**
4. Click **Activate**

### Manual

1. Clone or download this repository
2. Copy the contents into `/wp-content/plugins/playquiznow/`
3. Activate through **Plugins → Installed Plugins**

---

## Usage

### Shortcode

Add this to any post, page, or widget area:

```
[playquiznow id="your-quiz-id"]
```

With all options:

```
[playquiznow id="your-quiz-id" width="600px" height="700" theme="dark"]
```

### Gutenberg Block

1. In the block editor, click **+** to add a block
2. Search for **PlayQuizNow**
3. Enter your quiz ID in the input field
4. Adjust width, height, and theme from the sidebar panel

The block shows a live preview of your quiz right in the editor.

### Parameters

| Parameter | Default | Description |
|-----------|---------|-------------|
| `id`      | —       | **Required.** Your quiz ID from the PlayQuizNow dashboard |
| `width`   | `100%`  | Container width — any CSS value (`100%`, `600px`, `80vw`) |
| `height`  | `500`   | Initial height in pixels. Auto-resizes as the quiz loads |
| `theme`   | `light` | `light` or `dark` |

---

## Settings

Go to **Settings → PlayQuizNow** to configure:

| Setting | Default | Description |
|---------|---------|-------------|
| Default Width | `100%` | Default width for all embeds |
| Default Height | `500px` | Default height for all embeds |
| Show Branding | On | Display "Powered by PlayQuizNow" link below quizzes |
| Lazy Load | On | Load iframes lazily for better page performance |

Individual shortcode/block attributes override these defaults.

---

## How It Works

The plugin renders a sandboxed `<iframe>` pointing to:

```
https://playquiznow.com/embed/{quiz-id}?theme={theme}&source=wordpress
```

A lightweight frontend script listens for `postMessage` events from the embed:

- **`playquiznow:resize`** — automatically adjusts iframe height to fit content
- **`playquiznow:quiz-complete`** — fires a Google Analytics event (`quiz_complete`) if gtag.js is loaded

All messages are origin-validated against `https://playquiznow.com`. Resize heights are capped at 5000px.

---

## Finding Your Quiz ID

1. Log in at [playquiznow.com](https://playquiznow.com)
2. Open your quiz from the dashboard
3. The quiz ID is shown on the quiz settings page (e.g. `my-quiz-id`)

Don't have a quiz yet? [Create one free](https://playquiznow.com).

---

## Development

```bash
# Clone the repo
git clone https://github.com/varungulati/playquiznow-wordpress.git

# Create a symlink in your local WordPress plugins directory
ln -s /path/to/playquiznow-wordpress /path/to/wordpress/wp-content/plugins/playquiznow

# Regenerate the .pot file (requires WP-CLI)
wp i18n make-pot . languages/playquiznow.pot --slug=playquiznow
```

### Building the ZIP

```bash
cd .. && zip -r playquiznow.zip playquiznow-wordpress/ \
  -x "playquiznow-wordpress/.git/*" \
  -x "playquiznow-wordpress/.gitignore" \
  -x "playquiznow-wordpress/playquiznow.zip"
```

---

## License

GPLv2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html).
