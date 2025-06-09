## The Explanation

### **The Problem to be Solved**

Website owners, particularly those managing content-rich homepages, face a challenge: they don't know which of their navigation links or calls-to-action are immediately visible to visitors without scrolling. This "above the fold" area is prime digital real estate. Understanding which links are seen by the majority of users upon landing on the homepage is critical for optimizing user experience and conversion rates. The goal is to provide website owners with clear, actionable data on which hyperlinks are visible within the initial viewport for every visit to their homepage over the last week.

### **Technical Specification of the Design**

The **FoldClick Insights** plugin is an integrated solution that works within the WordPress ecosystem to collect, store, display, and manage hyperlink visibility data.

#### **How It Works**

The process can be broken down into five core components:

1.  **Data Collection (Frontend - `assets/js/tracker.js`)**:
    -   When a user visits the homepage, a lightweight JavaScript file is loaded.
    -   This script waits for the page to fully load (`DOMContentLoaded`).
    -   It then determines the visitor's viewport dimensions (`window.innerHeight` and `window.innerWidth`).
    -   Using the `getBoundingClientRect()` method, it iterates through all hyperlink (`<a>`) elements on the page.
    -   It checks if an element's top position is within the visible portion of the screen (i.e., its top coordinate is greater than or equal to 0 and less than or equal to the viewport's height).
    -   The `href` and inner text of all visible links are collected into an array.
2.  **Data Transmission (REST API)**:
    -   The collected data (screen dimensions and the array of visible links) is bundled into a JSON object.
    -   It is sent asynchronously via a `POST` request to a custom WordPress REST API endpoint: `/wp-json/foldclick-insights/v1/track`.
    -   A WordPress nonce is included in the request headers to provide a basic layer of security against Cross-Site Request Forgery (CSRF) attacks.
3.  **Data Storage (Backend - Custom Database Table)**:
    -   The REST API endpoint is handled by a dedicated PHP class (`FCI_Rest_Api`).
    -   Upon receiving the data, the endpoint sanitizes the inputs and inserts a new record into a custom database table named `wp_foldclick_insights`.
    -   This table is created upon plugin activation and has columns for an ID, visit timestamp, screen width, screen height, and a `TEXT` column to store the JSON-encoded array of visible hyperlinks.
4.  **Data Display (Backend - Admin Page)**:
    -   A new page, "FoldClick Insights," is added to the WordPress admin menu (`FCI_Admin_Menu`).
    -   When an admin visits this page, the plugin queries the `wp_fci_link_tracking` table for all records from the last seven days.
    -   The data is presented in a clear, tabular format, showing the visit time, the visitor's screen size, and a list of the hyperlinks that were visible above the fold for that specific visit.
5.  **Data Maintenance (WP-Cron)**:
    -   To prevent indefinite database growth, a scheduled event (`wp_cron`) is registered (`FCI_Cron`).
    -   This cron job runs once daily. Its sole purpose is to execute a `DELETE` query on the `wp_fci_link_tracking` table, removing any records that are older than seven days. This ensures the data is always fresh and relevant, as per the user story.

### **Technical Decisions and Rationale**

Several key decisions were made during the plugin's design to ensure it is modern, efficient, and compliant with WordPress best practices.

-   **Using a Custom Database Table**:
    -   **Decision**: I opted for a custom database table (`wp_fci_link_tracking`) instead of using existing tables like `wp_options` or `wp_postmeta`.
    -   **Why**: The data being collected is relational and transactional, with each row representing a unique visit. Storing this in `wp_postmeta` would be inefficient and semantically incorrect. `wp_options` is for site-wide settings and would perform poorly with a high volume of writes. A custom table provides data isolation, better performance for queries, and makes data management (like the 7-day cleanup) trivial and highly efficient.
-   **Modern OOP with PSR Standards**:
    -   **Decision**: The plugin is architected using Object-Oriented Programming (OOP) principles, with each major feature (REST API, Admin Menu, Cron, etc.) encapsulated in its own class.
    -   **Why**: This approach enhances code organization, maintainability, and scalability. It prevents naming conflicts and aligns with modern PHP development practices. While not strictly enforcing a PSR autoloader for this small plugin, the structure is PSR-4 friendly and avoids global variables.
-   **WordPress REST API Endpoint**:
    -   **Decision**: A custom REST API endpoint was created to receive data from the frontend script.
    -   **Why**: The REST API is the modern, standard way to handle AJAX requests in WordPress. It's more flexible and robust than the older `admin-ajax.php` method. It also benefits from built-in WordPress functionality like user authentication and nonce handling, making it a secure choice.
-   **WP-Cron for Cleanup**:
    -   **Decision**: The 7-day data purge is handled by a WP-Cron task.
    -   **Why**: WP-Cron is the native WordPress solution for scheduling tasks. It's reliable and integrates seamlessly without requiring server-level cron job configuration from the user, making the plugin self-contained and easy to manage.
-   **No New Global Variables**:
    -   **Decision**: The plugin strictly avoids creating new global variables.
    -   **Why**: Globals are a bad practice in WordPress as they pollute the global namespace and can lead to conflicts with other plugins or themes. All data is passed as parameters or managed within class instances.

### **How the Solution Achieves the Admin's Desired Outcome**

The **FoldClick Insights** plugin directly fulfills the website owner's user story: _"As a website owner, I want to know which hyperlinks were seen above the fold when someone opened my homepage over the past 7 days so that I can optimize the layout based on recent visits."_

-   **"Know which hyperlinks were seen above the fold..."**: The JavaScript tracker accurately identifies only the links visible in the initial viewport. This data is the core of what the plugin collects.
-   **"...when someone opened my homepage..."**: The tracking script is specifically enqueued to load _only_ on the homepage (`is_front_page()`), ensuring data is collected from the correct location.
-   **"...over the past 7 days..."**: The WP-Cron job automatically prunes data older than seven days, meaning the insights are always focused on recent user behavior, which is exactly what's needed for timely optimizations.
-   **"...so that I can optimize the layout based on recent visits."**: The "FoldClick Insights" admin page provides a clear, visit-by-visit breakdown of the collected data. The owner can see the different screen sizes of their visitors and, more importantly, which key links are (or are not) visible. This allows them to make informed decisions, such as moving an important but rarely seen link higher on the page or re-evaluating the placement of calls-to-action.