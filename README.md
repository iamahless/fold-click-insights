
# **FoldClick Insights**
A WordPress plugin that provides website owners with insights into which hyperlinks are visible "above the fold" on their homepage, helping them optimize layout and user engagement.

## **Description**
Do you know which of your key links and calls-to-action are immediately visible to your visitors? The "above the fold" section of your homepage is your most valuable digital real estate.

**FoldClick Insights** solves this problem by tracking every hyperlink that is visible within a user's browser viewport when they land on your homepage. It collects this data, along with the user's screen size, and presents it in a clear dashboard. This allows you to make data-driven decisions about your homepage layout to ensure your most important content gets the visibility it deserves.

The plugin is lightweight, privacy-conscious (it collects no personal data), and designed to have a negligible impact on site performance.

## **Features**
-   **Above-the-Fold Link Tracking**: Automatically identifies and records all hyperlinks visible on the homepage without scrolling.
-   **Screen Size Detection**: Captures the visitor's screen width and height to provide context for link visibility.
-   **Insights Dashboard**: A clean and simple admin page within WordPress to view the collected data.
-   **7-Day Data Retention**: The plugin only stores data from the last seven days, keeping your database clean and the insights relevant to recent traffic patterns.
-   **Automatic Data Pruning**: A daily cron job automatically removes outdated data, requiring no manual maintenance.
-   **Developer Friendly**: Built with modern, object-oriented PHP and a PSR-4 compliant structure for easy extension and maintenance.

## **Requirements**
-   **WordPress Version:** 5.0 or higher
-   **PHP Version:** 7.3 or higher

## **Installation**
You can install the **FoldClick Insights** plugin in two ways:

#### **Method 1: Install via WordPress Admin Dashboard (Easiest)**
1.  Download the latest release as a `.zip` file from the [GitHub repository releases page](https://github.com/iamahless/foldclick-insights/releases).
2.  Navigate to your WordPress Admin Dashboard.
3.  Go to **Plugins** -> **Add New**.
4.  Click the **Upload Plugin** button at the top of the page.
5.  Select the `.zip` file you downloaded and click **Install Now**.
6.  Once the installation is complete, click **Activate Plugin**.

#### **Method 2: Manual Installation via FTP/SFTP**
1.  Download and unzip the latest release from the [GitHub repository](https://github.com/iamahless/foldclick-insights/archive/refs/heads/main.zip).
2.  You will have a folder named `foldclick-insights`.
3.  Using an FTP or SFTP client, upload the `foldclick-insights` folder to the `/wp-content/plugins/` directory on your web server.
4.  Navigate to your WordPress Admin Dashboard.
5.  Go to **Plugins** -> **Installed Plugins**.
6.  Find **FoldClick Insights** in the list and click **Activate**.

## **How to Use**
Once the plugin is activated, it will immediately begin tracking visits to your homepage.
1.  To view the collected data, go to your WordPress Admin Dashboard.
2.  In the left-hand menu, click on **FoldClick Insights**.
3.  On this page, you will see a table listing all recorded homepage visits from the last seven days.
4.  The table displays:
    -   **Created At**: The date and time of the visit.
    -   **Screen Size**: The visitor's screen resolution (width x height).
    -   **Links**: A list of all links that were visible above the fold for that visit.

Use this data to analyze which links are consistently visible across different screen sizes and which important links might be getting missed by most users.