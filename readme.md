# Visitor Counter Website

A simple, visually appealing web page that tracks page views using the browser's local storage. It keeps track of:

- **Total Views**: Total visits to the page.
- **Today's Views**: Views for the current day.
- **Your Views**: Number of times you personally visited.
- **Last Visit**: Timestamp of your last visit.

## Features

- **Local Storage**: Counts persist between sessions.
- **Daily Tracking**: Resets daily for today's views.
- **User Specific**: Tracks individual user visits.
- **Refresh & Reset Buttons**: Update or reset counters easily.
- **Responsive Design**: Works on both desktop and mobile.
- **Animated Counter**: Smooth scaling effect when updated.

## How It Works

1. The page uses **JavaScript** to increment counters on load or when clicking the **Refresh** button.
2. Data is stored in the browser's **localStorage**, ensuring persistence across sessions.
3. **Reset** button clears all counters for a fresh start.
4. Today's views are reset automatically if the date changes.

## Usage

1. Open `index.html` in any modern browser.
2. View your total, today's, and personal page views.
3. Use the **Refresh** button to manually increase counters.
4. Use the **Reset** button to clear all counters.

## Technologies

- HTML5
- CSS3 (Flexbox & Grid)
- JavaScript (ES6)
- Font Awesome for icons

