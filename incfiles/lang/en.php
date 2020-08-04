<?php
/**
 * ========== About ==========
 * Author     : Afid Arifin
 * Name       : INTBYTE File Sharing (IFS)
 * Version    : v1.0
 * Created On : 09 October 2019
 */

/**
 * ========== WARNING BEFORE USING ==========
 * About            : see /documents/about.txt
 * Contact          : see /documents/contact.txt
 * Disclaimer       : see /documents/disclaimer.txt
 * Privacy Policy   : see/documents/privacy-policy.txt
 * License Software : see /documents/license.txt
 */

// To Debugging, You can change the number zero to number one to display the message
ini_set('display_errors', 0);

// Welcome
$lang['welcome_SERVICE_STORAGE'] = 'Storage';
$lang['welcome_SERVICE_STORCONT'] = 'We provide 5GB of storage with a maximum upload per file of 250MB.';
$lang['welcome_SERVICE_MONETIZE'] = 'Monetize Ads';
$lang['welcome_SERVICE_MONECONT'] = 'Monetize your files every time you upload files with our unlimited ad features.';
$lang['welcome_SERVICE_SECURITY'] = 'Security';
$lang['welcome_SERVICE_SECUCONT'] = 'No need to worry about the security of your files on our server. Your file is completely safe on our system. ';
$lang['welcome_SERVICE_UPGRADE'] = 'Upgrade Account';
$lang['welcome_SERVICE_UPGRCONT'] = 'Get 2 times more storage than a free account by increasing your account.';

// header
$lang['header_home'] = 'Home';
$lang['header_notifications'] = 'Notifications';
$lang['header_MAAR'] = 'Mark All Read';
$lang['header_VA'] = 'View All';
$lang['header_UNN'] = 'No notification.';
$lang['header_profile'] = 'Profile';
$lang['header_dashboard'] = 'Dashboard';
$lang['header_settings'] = 'Settings';
$lang['header_signout'] = 'Sign Out';
$lang['header_UAG'] = 'Guest';
$lang['header_PLF'] = 'You are not logged in';
$lang['header_login'] = 'Login Account';
$lang['header_register'] = 'Register Account';
$lang['header_notifications'] = 'Notifications';
$lang['header_SELECT_LANG'] = 'Language';
$lang['header_latest_upload'] = 'Latest Uploads';
$lang['header_popular_download'] = 'Popular Download';

// Sidebar
$lang['home_SAA'] = 'Admin Advertisement';
$lang['home_SE'] = 'Email';
$lang['home_SMA'] = 'Manage Administrators';
$lang['home_SMAD'] = 'Manage User Ads';
$lang['home_SMAD_UAA'] = 'Ad Approved';
$lang['home_SMAD_UAR'] = 'Ad Rejected';
$lang['home_SMAD_UAB'] = 'Ad Blocked';
$lang['home_SMAD_UAD'] = 'Ad Deleted';
$lang['home_SMAD_UAW'] = 'Wait To Approve';
$lang['home_SMF'] = 'Manage Files';
$lang['home_SMF_LU'] = 'Latest Uploads';
$lang['home_SMF_PD'] = 'Popular Download';
$lang['home_SMF_RF'] = 'File Report';
$lang['home_SMN'] = 'Manage Notifications';
$lang['home_SMN_CN'] = 'Create Notification';
$lang['home_SMN_NN'] = 'Latest Notification';
$lang['home_SMN_AN'] = 'Notification Archive';
$lang['home_SMU'] = 'Manage Users';
$lang['home_SMU_LU'] = 'User List';
$lang['home_SMU_UB'] = 'User Blocked';
$lang['user_LIST_CONFIRMED'] = 'Confirmed User';
$lang['home_SMU_UC'] = 'User Not Confirmed';
$lang['home_SMU_UPA'] = 'Premium Account';
$lang['home_SS'] = 'Settings';
$lang['home_SS_SEO'] = 'SEO Settings';
$lang['home_SS_SITE'] = 'Site Settings';
$lang['home_SS_STORAGE'] = 'Storage Settings';
$lang['home_SS_AVATAR'] = 'Edit Avatar';
$lang['home_SAAC'] = 'Upgrade Account';
$lang['home_SUAP'] = 'Premium Ads';
$lang['home_SUMAD'] = 'My Advertisement';
$lang['home_SUMAD_CNA'] = 'Create a New Ad';
$lang['home_SUMAD_AA'] = 'Active Advertising';
$lang['home_SUMAD_UAA'] = 'Ad Approved';
$lang['home_SUMAD_UAR'] = 'Ad Rejected';
$lang['home_SUMAD_UAB'] = 'Ad Blocked';
$lang['home_SUMAD_UAD'] = 'Ad Deleted';
$lang['home_SUMAD_UAW'] = 'Wait To Approve';
$lang['home_SUMF'] = 'My File';
$lang['home_SUMF_LF'] = 'File List';
$lang['home_SUMF_UF'] = 'Upload File';
$lang['home_SUMF_IF'] = 'Import File';
$lang['home_SUMF_RF'] = 'File Report';
$lang['home_SUMF_PF'] = 'Popular Files';
$lang['home_SUMFF'] = 'My Folder';
$lang['home_SUN'] = 'Notification';
$lang['home_SS_PROFILE'] = 'Edit Profile';
$lang['home_SS_PASSWORD'] = 'Edit Password';
$lang['home_SS_DELETE'] = 'Delete Account';
$lang['home_SCU'] = 'Contact Us';
$lang['home_SCU_EMAIL'] = 'Via Email';
$lang['home_SCU_MESSENGER'] = 'Via Messenger';
$lang['home_SUMFA'] = 'Add Folder';
$lang['home_SS_WELCOME'] = 'Welcome';

// Administrator Index
$lang['admin_STORAGE_USED'] = 'USED';
$lang['admin_USERS'] = 'TOTAL USERS';
$lang['admin_TOTAL_ADMIN'] = 'TOTAL ADMIN';
$lang['admin_TOTAL_FILES'] = 'TOTAL FILES';

// administrator
$lang['admin_LT'] = 'List of Administrators';
$lang['admin_AL'] = 'List of Administrators';
$lang['admin_USERNAME'] = 'Username';
$lang['admin_REGISTERED'] = 'Registered';
$lang['admin_EMAIL'] = 'Email';
$lang['admin_LEVEL'] = 'Level';
$lang['admin_STATUS'] = 'Status';
$lang['admin_ACTION'] = 'Action';
$lang['admin_DFA'] = 'Remove this user from the administrator list.';
$lang['admin_SP'] = 'View Profile';
$lang['admin_AYS'] = 'Are you sure?';
$lang['admin_AYS_CONFIRM'] = 'Are you sure you want to delete';
$lang['admin_AYS_SUCCESS'] = 'Successfully deleted this user from the administrator list.';
$lang['admin_AYS_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['admin_CNTD1'] = 'You cannot delete yourself because you are the main Admin.';
$lang['admin_CNTD2'] = 'You cannot delete the primary Admin.';
$lang['admin_BDWN_ACTION'] = 'Actions';
$lang['admin_BDWN_DELETE'] = 'Delete';
$lang['admin_BDWN_SEE'] = 'View Profile';

// Admin Advertisement
$lang['ads_NHP'] = 'You do not have permission to access this page.';
$lang['ads_EAU'] = 'Please fill in your ad units!';
$lang['ads_NATA'] = 'Ad types not supported. Please use JavaScript or HTML type ads!';
$lang['ads_STU'] = 'Your ad has been updated successfully.';
$lang['ads_FTU'] = 'Your ad failed to update.';
$lang['ads_YAU'] = 'Your Ad Unit';
$lang['ads_PFIYAU'] = 'Please fill in your ad units!';
$lang['ads_PUBLISH'] = 'Update';
$lang['ads_CLEAR'] = 'Clean';
$lang['ads_PREVIEW'] = 'Ad Preview';
$lang['ads_YHNAU'] = 'You do not have an active ad unit at this time.';
$lang['ads_LAST_UPDATE'] = 'Last updated';

// User File
$lang['userFile_LATEST_UPLOAD'] = 'Latest Uploads';
$lang['userFile_POPULAR_DOWNLOAD'] = 'Popular Download';
$lang['userFile_REPORTED'] = 'File Report';
$lang['userFile_NAME'] = 'File Name';
$lang['userFile_FOLDER'] = 'Folder';
$lang['userFile_SIZE'] = 'Size';
$lang['userFile_TIME'] = 'Uploaded to';
$lang['userFile_DOWNLOADED'] = 'Downloaded';
$lang['userFile_UPLOADED_BY'] = 'Uploaded By';
$lang['userFile_FOLDER_T'] = 'This file is saved in the folder';
$lang['userFile_REPORT'] = 'Reported';
$lang['userFile_ACTION'] = 'Action';
$lang['userFile_BDWN_ACTION'] = 'Actions';
$lang['userFile_BDWN_DELETE'] = 'Delete';
$lang['userFile_BDWN_MOVE'] = 'Move';
$lang['userFile_BDWN_EDIT'] = 'Edit';
$lang['userFile_BDWN_SEE'] = 'View File';
$lang['userFile_CONFIRM_AYS'] = 'Are you sure?';
$lang['userFile_CONDELETE_TEXT'] = 'Are you sure you want to delete this file permanently?';
$lang['userFile_CONDELETE_SUCCESS'] = 'Successfully deleted this file.';
$lang['userFile_CONDELETE_CANCEL'] = 'Thank you, you have just canceled your action.';

// Settings
$lang['settings_SEO'] = 'SEO settings';
$lang['settings_SITE'] = 'Site Settings';
$lang['settings_STORAGE'] = 'Storage Settings';
$lang['settings_SEO_TEXT'] = 'Basic SEO settings such as, description, keywords, Robots.txt and Google Verification.';
$lang['settings_SEO_SD'] = 'Site Description';
$lang['settings_SEO_SK'] = 'Site Keywords';
$lang['settings_SEO_RT'] = 'Robots.txt';
$lang['settings_SEO_GV'] = 'Google Verification';
$lang['settings_SEO_IFSD'] = 'Please fill in the site description!';
$lang['settings_SEO_IFSK'] = 'Please enter a site password!';
$lang['settings_SEO_IFRT'] = 'Please fill in robots.txt!';
$lang['settings_SEO_IFGV'] = 'Please fill in Google Verify code!';
$lang['settings_SEO_SAVE'] = 'Save Changes';
$lang['settings_SEO_ALRM'] = 'WARNING!';
$lang['settings_SEO_ALRMS'] = 'SUCCESS!';
$lang['settings_SEO_IDST'] = 'Please fill in all required data.';
$lang['settings_SEO_ISDT'] = 'The system only recommends 150 characters in length for your site description.';
$lang['settings_SEO_ISKT'] = 'The system only recommends 150 words in length for your site\'s keywords.';
$lang['settings_SEO_IRTT'] = 'The system only recommends 200 characters for your Robots.txt.';
$lang['settings_SEO_IGVT'] = 'Your Google Verification Code is invalid.';
$lang['settings_SEO_SUCCESS'] = 'SEO settings successfully updated.';
$lang['settings_SEO_FAILED'] = 'SEO settings failed.';
$lang['settings_SITE_TEXT'] = 'Basic site settings such as site title, registration status, time zone, site maintenance mode, language and so on.';
$lang['settings_SITE_TITLE'] = 'Site Title';
$lang['settings_SITE_REG'] = 'Registration Status';
$lang['settings_SITE_REGSS'] = 'Select Status';
$lang['settings_SITE_REGOR'] = 'Open Registration';
$lang['settings_SITE_REGCR'] = 'Close Registration';
$lang['settings_SITE_VS'] = 'Verification Status';
$lang['settings_SITE_VSSS'] = 'Select Status';
$lang['settings_SITE_VSA'] = 'Active';
$lang['settings_SITE_VSNA'] = 'Off';
$lang['settings_SITE_TZ'] = 'Time Zone';
$lang['settings_SITE_MTC'] = 'Maintenance Mode';
$lang['settings_SITE_MTCSM'] = 'Select Mode';
$lang['settings_SITE_MTCOM'] = 'Open';
$lang['settings_SITE_MTCCM'] = 'Close';
$lang['settings_SITE_LANG'] = 'Language';
$lang['settings_SITE_LANGSL'] = 'Select Language';
$lang['settings_SITE_SAVE'] = 'Save Changes';
$lang['settings_SITE_ALRM'] = 'WARNING!';
$lang['settings_SITE_ALRMS'] = 'SUCCESS!';
$lang['settings_SITE_IDST'] = 'Please fill in all necessary data.';
$lang['settings_SITE_IFT'] = 'Please fill in the title of your site!';
$lang['settings_SITE_IFR'] = 'Please select registration status.';
$lang['settings_SITE_IFV'] = 'Please select registration verification status.';
$lang['settings_SITE_IFTZ'] = 'Please enter a time zone!';
$lang['settings_SITE_IFM'] = 'Please select maintenance mode!';
$lang['settings_SITE_IFL'] = 'Please choose your default language!';
$lang['settings_SITE_RSN'] = 'Please select registration status!';
$lang['settings_SITE_VSN'] = 'Please select registration verification status!';
$lang['settings_SITE_MMN'] = 'Please select maintenance mode!';
$lang['settings_SITE_DLN'] = 'Please choose your default language!';
$lang['settings_SITE_SUCCESS'] = 'Site settings updated successfully.';
$lang['settings_SITE_FAILED'] = 'Site settings failed to update.';
$lang['settings_SITE_PAGING'] = 'Views Per Page';
$lang['settings_SITE_PAGING2'] = 'Select Amount';
$lang['settings_SITE_PAGING3'] = 'page';
$lang['settings_SITE_PAGINGN'] = 'Please select the amount per page!';
$lang['settings_SITE_IFP'] = 'Please fill in the amount per page!';
$lang['settings_SITE_CURRENCY'] = 'Currency Exchange';
$lang['settings_SITE_CURRENCYN'] = 'Currency only supports numbers!';
$lang['settings_SITE_IFC'] = 'Please fill in your currency!';
$lang['settings_SITE_PAYPAL'] = 'Paypal Code';
$lang['settings_SITE_IFPP'] = 'Please enter your paypal html code!';
$lang['settings_SITE_BANK'] = 'Bank';
$lang['settings_SITE_IFBK'] = 'Please enter your bank account!';
$lang['settings_SITE_OTHERS'] = 'Other';
$lang['settings_SITE_IFBO'] = 'Enter another payment!';
$lang['settings_STORAGE_TEXT'] = 'Storage settings such as per user storage, per file upload, and prohibited file extensions.';
$lang['settings_STORAGE_SPU'] = 'Storage Per User';
$lang['settings_STORAGE_UPF'] = 'Upload Per File';
$lang['settings_STORAGE_NAE'] = 'Extension Prohibited';
$lang['settings_STORAGE_IFSPU'] = 'Please fill out storage per user!';
$lang['settings_STORAGE_IFUPF'] = 'Please fill per file upload!';
$lang['settings_STORAGE_IFNAE'] = 'Please fill in extensions not allowed!';
$lang['settings_STORAGE_SAVE'] = 'Save Changes';
$lang['settings_STORAGE_ALRM'] = 'WARNING!';
$lang['settings_STORAGE_ALRMS'] = 'SUCCESS!';
$lang['settings_STORAGE_IDST'] = 'Please fill in all necessary data.';
$lang['settings_STORAGE_IISU'] = 'Only supports number formats in BYTE units.';
$lang['settings_STORAGE_IE'] = 'Please limit only spaces and commas.';
$lang['settings_STORAGE_SUCCESS'] = 'The saving settings have been updated successfully.';
$lang['settings_STORAGE_FAILED'] = 'The storage settings failed to update.';
$lang['settings_STORAGE_USED'] = 'USED';
$lang['settings_STORAGE_PHS'] = 'Enter in MB and only in numbers ...';
$lang['settings_STORAGE_PHE'] = 'Enter your extension ...';

// User Ads
$lang['userAds_APPROVE'] = 'List of Approved Ads';
$lang['userAds_REJECT'] = 'List of Ad Rejected';
$lang['userAds_BLOCK'] = 'List of Ads Blocked';
$lang['userAds_DELETE'] = 'List of Ads Deleted';
$lang['userAds_WTA'] = 'Ad List Wait To Approve';
$lang['userAds_CONTENT'] = 'Content';
$lang['userAds_ON_DATE'] = 'On';
$lang['userAds_ADS_BY'] = 'Ad By';
$lang['userAds_STATUS'] = 'Status';
$lang['userAds_ACTION'] = 'Action';
$lang['userAds_BDWN_ACTION'] = 'Actions';
$lang['userAds_BDWN_APPROVE'] = 'Approve';
$lang['userAds_BDWN_BLOCK'] = 'Block';
$lang['userAds_BDWN_REJECT'] = 'Reject';
$lang['userAds_BDWN_DELETE'] = 'Delete';
$lang['userAds_BDWN_PREVIEW'] = 'Preview';
$lang['userAds_CONFIRM_AYS'] = 'Are you sure?';
$lang['userAds_CONAPPROVE_TEXT'] = 'Are you sure you want to approve this user\'s ad?';
$lang['userAds_CONAPPROVE_SUCCESS'] = 'The user\'s ad has been successfully approved.';
$lang['userAds_CONAPPROVE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['userAds_CONBLOCK_TEXT'] = 'Are you sure you want to block this user\'s ads? This user\'s ads cannot be resubmitted by users.';
$lang['userAds_CONBLOCK_SUCCESS'] = 'The user\'s ad has been successfully blocked.';
$lang['userAds_CONBLOCK_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['userAds_CONREJECT_TEXT'] = 'Are you sure you want to reject this user\'s ad? You can approve this user\'s ad at any time.';
$lang['userAds_CONREJECT_SUCCESS'] = 'The user\'s ad was successfully rejected.';
$lang['userAds_CONREJECT_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['userAds_CONDELETE_TEXT'] = 'Are you sure you want to delete this user\'s ad? This ad can be re-submitted by the user.';
$lang['userAds_CONDELETE_SUCCESS'] = 'The user\'s ad was successfully deleted.';
$lang['userAds_CONDELETE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['userAds_CONDROP_SUCCESS'] = 'Successfully deleted all advertisements.';
$lang['userAds_CONDROP_CANCEL'] = 'Thank you, you have just canceled your action.';

// users
$lang['user_LIST'] = 'User List';
$lang['user_LIST_BLOCK'] = 'User Blocked';
$lang['user_LIST_UNCONFIRM'] = 'Not confirmed';
$lang['user_LIST_CONFIRMED'] = 'Confirmed User';
$lang['user_LIST_PA'] = 'Premium Account';
$lang['user_LIST_USERNAME'] = 'Username';
$lang['user_LIST_REGISTERED'] = 'Registered';
$lang['user_LIST_EMAIL'] = 'Email';
$lang['user_LIST_LEVEL'] = 'Level';
$lang['user_LIST_STATUS'] = 'Status';
$lang['user_LIST_ACTION'] = 'Action';
$lang['user_LIST_BDWN_ACTION'] = 'Actions';
$lang['user_LIST_BDWN_BLOCK'] = 'Block';
$lang['user_LIST_BDWN_UNBLOCK'] = 'Unblock';
$lang['user_LIST_BDWN_DELETE'] = 'Delete';
$lang['user_LIST_BDWN_SEE'] = 'View Profile';
$lang['user_LIST_BDWN_UPA'] = 'Upgrade Account';
$lang['user_LIST_BDWN_DPA'] = 'Account Downgrade';
$lang['user_LIST_CONFIRM_AYS'] = 'Are you sure?';
$lang['user_LIST_CONBLOCK_TEXT'] = 'Are you sure you want to block this user? this will prevent the user from accessing his account.';
$lang['user_LIST_CONBLOCK_SUCCESS'] = 'Your user has been successfully blocked.';
$lang['user_LIST_CONBLOCK_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['user_LIST_CONDELETE_TEXT'] = 'Are you sure you want to delete this user permanently?';
$lang['user_LIST_CONDELETE_SUCCESS'] = 'You have successfully deleted your user.';
$lang['user_LIST_CONDELETE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['user_LIST_CONUNBLOCK_TEXT'] = 'Are you sure you want to unblock this user?';
$lang['user_LIST_CONUNBLOCK_SUCCESS'] = 'Your user has successfully blocked it.';
$lang['user_LIST_CONUNBLOCK_CANCEL'] = 'Thank you, you have just canceled your action.';

// time
$lang['timeAgoYears'] = 'years ago';
$lang['timeAgoMonths'] = 'months ago';
$lang['timeAgoWeeks'] = 'weeks';
$lang['timeAgoDays'] = 'days ago';
$lang['timeAgoHours'] = 'hours ago';
$lang['timeAgoMinutes'] = 'minutes ago';
$lang['timeAgoJustNow'] = 'Just now';

// status
$lang['status_NC'] = 'This user has not confirmed the account.';
$lang['status_C'] = 'This user has confirmed the account.';
$lang['status_NCA'] = 'NOT CONFIRMED';
$lang['status_CA'] = 'CONFIRMED';
$lang['status_UAD_APPROVE'] = 'This user\'s ad has been successfully approved.';
$lang['status_UAD_REJECT'] = 'This user\'s ad was successfully rejected.';
$lang['status_UAD_BLOCK'] = 'This user\'s ad has been successfully blocked.';
$lang['status_UAD_DELETE'] = 'This user\'s ad has been successfully deleted.';
$lang['status_UAD_WTA'] = 'This user\'s ad is waiting to be approved.';
$lang['status_UAD_APPROVED'] = 'Approved';
$lang['status_UAD_REJECTED'] = 'Rejected';
$lang['status_UAD_BLOCKED'] = 'Blocked';
$lang['status_UAD_DELETED'] = 'Deleted';
$lang['status_UAD_WTA2'] = 'Waiting';
$lang['status_BLOCKED'] = 'BLOCKED';
$lang['status_USER'] = 'USER';

// Notifications
$lang['notify_CREATE'] = 'Create Notification';
$lang['notify_CREATE_TITLE'] = 'Title';
$lang['notify_CREATE_ST'] = 'Select Type';
$lang['notify_CREATE_STN'] = 'News';
$lang['notify_CREATE_STI'] = 'Information';
$lang['notify_CREATE_STT'] = 'Bidding';
$lang['notify_CREATE_STU'] = 'User';
$lang['notify_CREATE_MESSAGE'] = 'Notification Message';
$lang['notify_CREATE_TFB'] = 'Please fill in the title of the notification!';
$lang['notify_CREATE_MFB'] = 'Please fill in the notification message!';
$lang['notify_CREATE_DLFB'] = 'Please fill in the notification type!';
$lang['notify_CREATE_RBTN'] = 'Clean up';
$lang['notify_CREATE_SBTN'] = 'Create Notification';
$lang['notify_CREATE_EMPTXT'] = 'Please fill in all necessary data.';
$lang['notify_CREATE_LENTL'] = 'The title must be at least 5 characters long and must consist of 2 words.';
$lang['notify_CREATE_CS'] = 'Please select the type and destination to whom your notification will be sent.';
$lang['notify_CREATE_LENMSG'] = 'The minimum contents of the notification message consists of 25 characters and 5 words.';
$lang['notify_CREATE_SUCCESS'] = 'Successfully added the latest notification.';
$lang['notify_CREATE_FAILED'] = 'Failed to add the latest notification.';
$lang['notify_CREATE_LU'] = 'Last Update';
$lang['notify_CREATE_BY'] = 'To';
$lang['notify_CREATE_NF'] = 'There was no notification.';
$lang['notify_NEW'] = 'Latest Notification';
$lang['notify_NEW_ARCHIVE'] = 'Notification Archive';
$lang['notify_NEW_TITLE'] = 'Title';
$lang['notify_NEW_CONTENT'] = 'Content';
$lang['notify_NEW_ON_DATE'] = 'On';
$lang['notify_NEW_BY'] = 'By';
$lang['notify_NEW_STATUS'] = 'Status';
$lang['notify_NEW_ACTION'] = 'Action';
$lang['notify_NEW_UNREAD'] = 'Unread';
$lang['notify_NEW_READ'] = 'Read';
$lang['notify_NEW_BDWN_ACTION'] = 'Actions';
$lang['notify_NEW_BDWN_READ'] = 'Read';
$lang['notify_NEW_BDWN_DELETE'] = 'Delete';
$lang['notify_NEW_CONFIRM_AYS'] = 'Are you sure?';
$lang['notify_NEW_CONDELETE_TEXT'] = 'Are you sure you want to delete this notification?';
$lang['notify_NEW_CONDELETE_SUCCESS'] = 'The notification was deleted successfully.';
$lang['notify_NEW_CONDELETE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['notify_DONE_BTN'] = 'Complete';
$lang['notify_DROP_ALL'] = 'Delete All';
$lang['notify_DROP_ALL2'] = 'All notification data will be deleted in one click.';
$lang['notify_NEW_CONDROP_TEXT'] = 'Are you sure you want to delete all notifications with one click?';
$lang['notify_NEW_CONDROP_SUCCESS'] = 'All notifications were deleted successfully.';
$lang['notify_NEW_CONDROP_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['notify_HEAD_CONDROP_TEXT'] = 'Your actions will edit all notifications to read.';
$lang['notify_HEAD_CONDROP_SUCCESS'] = 'All notifications have been read.';
$lang['notify_HEAD_CONDROP_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['notify_CREATE_TO'] = 'Send To Whom?';
$lang['notify_CREATE_STO'] = 'Select User';
$lang['notify_CREATE_TFB'] = 'Please select a shipping destination!';
$lang['notify_CONSO_TEXT'] = 'Are you sure you want to leave the account now?';
$lang['notify_CONSO_SUCCESS'] = 'Successfully logged out. Your session has ended.';
$lang['notify_CONSO_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['notify_OOPS'] = 'Oops! An error occurred while refreshing the page. Please try again later.';

// login
$lang['login_LOST_PASSWORD'] = 'Forgot your password';
$lang['login_RESET_PASSWORD'] = 'Reset Password';
$lang['login_PAGE'] = 'Login Account';
$lang['login_PAGE_EFB'] = 'Please enter your email!';
$lang['login_PAGE_PFB'] = 'Please enter your password!';
$lang['login_PAGE_PASSWORD'] = 'Password';
$lang['login_PAGE_RM'] = 'Remember Me';
$lang['login_PAGE_BTN'] = 'Login Account';
$lang['login_PAGE_DHA'] = 'Don\'t have an account?';
$lang['login_PAGE_CO'] = 'Create Now';
$lang['login_ALL_REQUIRED'] = 'Please enter all your login data correctly.';
$lang['login_INAVLID_EMAIL'] = 'Make sure the email you entered is correct.';
$lang['login_USER_BANNED'] = 'Your account has been blocked. Contact us to submit an appeal regarding your account.';
$lang['login_USER_STATUS'] = 'Please confirm your account before using our service.';
$lang['login_SUCCESS'] = 'Account login was successful. You will be diverted in 3 seconds.';
$lang['login_INVALID_PASSWORD'] = 'Your password is incorrect.';
$lang['login_NF_EMAIL'] = 'Your email is not registered with our system.';
$lang['login_SECURITY_SESSION'] = 'Your session was active before. For your security, we will automatically delete your session.';
$lang['login_LOST_PASSWORD_REQUEST'] = 'Request New';
$lang['login_LOST_PASSWORD_SEND'] = 'We will send a link to reset your new password.';
$lang['login_LOST_PASSWORD_SUCCESS'] = 'We have successfully sent your new password reset link. Check your email now.';
$lang['login_LOST_PASSWORD_FAILED'] = 'We failed to send your new password reset link.';
$lang['login_RESET_TFB'] = 'Please enter your token!';
$lang['login_RESET_PASSWORD_NEW'] = 'New Password';
$lang['login_RESET_NPFB'] = 'Please enter your new password!';
$lang['login_RESET_PASSWORD_CONFIRM'] = 'Repeat New Password';
$lang['login_RESET_CPFB'] = 'Please re-enter your new password!';
$lang['login_RESET_BTN'] = 'Reset Password';
$lang['login_MIN_PASSWORD'] = 'Password must contain at least 8 characters or more.';
$lang['login_INVALID_PASSWORD2'] = 'Verify your passwords do not match.';
$lang['login_INVALID_TOKEN'] = 'Your token is invalid or has expired.';
$lang['login_RESET_PASSWORD_SUCCESS'] = 'The password was reset successfully.';
$lang['login_RESET_PASSWORD_FAILED'] = 'The password failed to reset.';
$lang['login_STATUS_BANNED'] = 'Your account has been blocked. Contact us to submit an appeal regarding your account.';
$lang['login_STATUS_UNCONFIRMED'] = 'Please confirm your account before using our service.';
$lang['login_NF_ET'] = 'Your token has expired. Please ask again on the forgot password page.';
$lang['login_WARNING'] = 'There was an error processing your request.';
$lang['login_TOKEN_CLICKED'] = 'Token is used to ensure that you are the one who requested this edit. Forgot token? please request a new one.';
$lang['login_PASSWORD_SAME'] = 'You cannot use a previous password.';

// Register
$lang['register_PAGE'] = 'Create Account';
$lang['register_PAGE_WELCOME'] = 'Create an account easily with just one click.';
$lang['register_PAGE_USERNAME'] = 'Username';
$lang['register_PAGE_UFB'] = 'Please enter your username!';
$lang['register_PAGE_EFB'] = 'Please enter your email!';
$lang['register_PAGE_PASSWORD'] = 'Password';
$lang['register_PAGE_EFB'] = 'Please enter your email!';
$lang['register_PAGE_PASSWORD_CONFIRM'] = 'Repeat Password';
$lang['register_PAGE_AGREE'] = 'Agree to service policy';
$lang['register_PAGE_BTN'] = 'Create Account';
$lang['register_PAGE_PFB'] = 'Please enter your password!';
$lang['register_PAGE_PCFB'] = 'Please repeat your password!';
$lang['register_PAGE_DHA'] = 'Already have an account?';
$lang['register_PAGE_VERIFY'] = 'Account Verification';
$lang['register_PAGE_STATUS'] = 'Account Status';
$lang['register_ALL_REQUIRED'] = 'Please fill in all account creation data.';
$lang['register_INVALID_USERNAME'] = 'The username only supports alphanumeric and characters.-_';
$lang['register_LEN_USERNAME'] = 'The username must be 4 - 30 characters long.';
$lang['register_USERNAME_EXISTS'] = 'The username has been registered.';
$lang['register_INVALID_EMAIL'] = 'Invalid email. Please check your email again.';
$lang['register_LEN_EMAIL'] = 'Email length must be 4 - 30 characters.';
$lang['register_EMAIL_EXISTS'] = 'The email has been registered.';
$lang['register_LEN_PASSWORD'] = 'Password must contain at least 8 characters or more.';
$lang['register_INVALID_PASSWORD'] = 'Your passwords do not match. Please check your password again.';
$lang['register_SUCCESS_VERIFY'] = 'Please check your email to confirm your account.';
$lang['register_FAILED_VERIFY'] = 'Looks like we can\'t process your request right now.';
$lang['register_SUCCESS_WV'] = 'Your account was successfully created. Check email for your login details.';
$lang['register_FAILED_WV'] = 'Looks like we can\'t process your request right now.';
$lang['register_CLOSE'] = 'We are currently closing a new account. Please come again in any other time.';
$lang['register_INVALID_EMAIL'] = 'Invalid email. Please check your email again. ';
$lang['register_VERIFY_SUCCESS'] = 'Your account has been successfully confirmed.';
$lang['register_VERIFY_FAILED'] = 'Your account failed to be confirmed. Please take a few more moments.';
$lang['register_VERIFY_NFD'] = 'Your email or token has expired.';
$lang['register_VERIFY_I'] = 'Looks like we can\'t process your request.';

// search
$lang['search_RESULT'] = 'Search Results';
$lang['search_EMPTXT'] = 'Oops! please enter your search keywords.';
$lang['search_NO_RESULT'] = 'Your search for this keyword was not found in our database. Please check again.';
$lang['search_NO_RESULT2'] = 'Not found';
$lang['search_DOWNLOAD_BTN'] = 'This file is available for you to download with an estimated size';
$lang['search_NF_BTH'] = 'You will return to the previous page.';
$lang['search_NF_BTHB'] = 'Back';
$lang['search_SIZE_ESTIMATE'] = 'The estimated size of this file download is';
$lang['search_EMPTXT2'] = 'We could not find your search.';
$lang['search_SEE_PROFILE'] = 'View Profile';

// Upload File
$lang['upload_FILE'] = 'Upload File';
$lang['upload_FILE_TEXT'] = 'Upload your file and monetize your file. In your current account package, you can only upload a maximum of 2 files at a time. The current file size limit is';
$lang['upload_FILE_TEXT2'] = 'Upload your file and monetize your file. In your current account package you can only upload up to 4 files at a time. The current file size limit is';
$lang['upload_FILE_PASSWORD'] = 'Password';
$lang['upload_FILE_FOLDER'] = 'Folder';
$lang['upload_FILE_SF'] = 'Select Folder';
$lang['upload_FILE_DESCRIPTION'] = 'Description';
$lang['upload_FILE_USED'] = 'Remaining';
$lang['upload_FILE_BTN'] = 'Upload Now';
$lang['upload_FILE_USED2'] = 'Your storage is under 100 KB or has expired.<br/><a href="'.base_url().'/user/upgrade/?act=add_storage&view=package">Add Storage?</a>';
$lang['upload_FILE_USED3'] = 'In your current account package there is only available storage space of';
$lang['upload_FILE_CF'] = 'Select file';
$lang['upload_FILE_NSF'] = 'Please select a folder first.';
$lang['upload_FILE_FD'] = 'The file description only supports up to 5000 characters.';
$lang['upload_FILE_SF2'] = 'Select File';
$lang['upload_FILE_NFS'] = 'Please select at least one file that you want to upload.';
$lang['upload_FILE_NFS2'] = 'Make sure you fill in all the file fields that you added.';
$lang['upload_FILE_BS'] = 'too large to upload.';
$lang['upload_FILE_LS'] = 'Your storage has been used up.';
$lang['upload_FILE_NAE'] = 'File extension';
$lang['upload_FILE_NAE2'] = 'not supported.';
$lang['upload_FILE_SS'] = 'uploaded successfully.';
$lang['upload_FILE_FS'] = 'failed to upload.';
$lang['upload_FILE_FM'] = 'Oops! a system error has occurred.';
$lang['upload_FILE_HU'] = 'You have previously uploaded.';
$lang['upload_FILE_WARNING'] = '<b>Attention:</b>Do not upload files that violate our <a href="'.base_url().'/terms_of_service/">T.O.S</a> our service.';

// Import File
$lang['import_FILE'] = 'Import File';
$lang['import_FILE_TEXT2'] = 'Import your file and monetize your file. In your current account package, you can only import up to 4 files at a time. The current file size limit is';
$lang['import_FILE_TEXT'] = 'Import your file and monetize your file. In your current account package, you can only import up to 2 files at a time. The current file size limit is';
$lang['import_FILE_SF2'] = 'File URL';
$lang['import_FILE_CF'] = 'http: //';
$lang['import_FILE_FOLDER'] = 'Folder';
$lang['import_FILE_SF'] = 'Select Folder';
$lang['import_FILE_PASSWORD'] = 'Password';
$lang['import_FILE_DESCRIPTION'] = 'Description';
$lang['import_FILE_WARNING'] = '<b>Attention:</b> It is prohibited to import files that violate our <a href="'.base_url().'/terms_of_service/">T.O.S</a> our service.';
$lang['import_FILE_USED'] = 'Used';
$lang['import_FILE_BTN'] = 'Import Now';
$lang['import_FILE_USED2'] = 'Your storage is under 100 KB or has been used up.<br/><a href="'.base_url().'/user/upgrade/?act=add_storage&view=package">Add Storage?</a> ';
$lang['import_FILE_NSF'] = 'Please select a folder first.';
$lang['import_FILE_FD'] = 'The file description only supports up to 5000 characters.';
$lang['import_FILE_IVU'] = 'Your URL is in the wrong format.';
$lang['import_FILE_LS'] = 'Your storage has been used up.';
$lang['import_FILE_BS'] = 'too large to import.';
$lang['import_FILE_HU'] = 'You have imported it before.';
$lang['import_FILE_NAE'] = 'File Extension';
$lang['import_FILE_NAE2'] = 'not supported.';
$lang['import_FILE_SS'] = 'Imported successfully.';
$lang['import_FILE_FS'] = 'failed to import.';
$lang['import_FILE_FM'] = 'Oops! a system error has occurred. ';
$lang['import_FILE_NFS'] = 'Please enter at least one URL that you want to import.';
$lang['import_FILE_NFS2'] = 'Make sure you fill in all the URL fields you added.';

// My Ads
$lang['myads_CREATE'] = 'Create a New Ad';
$lang['myads_APPROVE'] = 'Ad Approved';
$lang['myads_REJECTED'] = 'Ad Rejected';
$lang['myads_BLOCKED'] = 'Ad Blocked';
$lang['myads_DELETED'] = 'Ad Deleted';
$lang['myads_WTA'] = 'Wait To Approve';
$lang['myads_CREATE_TEXT'] = 'Create new ads without restrictions and without waiting for administrator approval.';
$lang['myads_CREATE_TEXT2'] = 'Create a new ad without restrictions. Want without waiting for approval? <a href="'.base_url().'/user/upgrade/?act=upgrade_account">Upgrade an Account</a> now. ';
$lang['myads_CREATE_UA'] = 'Ad Unit';
$lang['myads_CREATE_IFBUA'] = 'Please enter your ad unit.';
$lang['myads_CREATE_CLEAR'] = 'Clean up';
$lang['myads_CREATE_PUBLISH'] = 'Create an Ad';
$lang['myads_CREATE_EUA'] = 'Please enter your ad unit.';
$lang['myads_CREATE_IUA'] = 'Your ad format is not supported.';
$lang['myads_CREATE_SS'] = 'Your new ad has been successfully created.';
$lang['myads_CREATE_FS'] = 'Your new ad failed to create.';
$lang['myads_CREATE_UAE'] = 'We do not allow you to create multiple ads.';
$lang['myads_CREATE_WARNING'] = 'Do not create ads that violate our <a href="'.base_url().'/terms_of_service">T.O.S </a>services.';
$lang['myads_CREATE_SS2'] = 'Your new ad has been successfully created. We are currently reviewing your ad.';
$lang['myads_CREATE_FS2'] = 'Your new ad failed to be created.';
$lang['myads_CREATE_UAB'] = 'You can no longer use this ad unit. Please contact the administrator for more information.';
$lang['myads_CONTENT'] = 'Content';
$lang['myads_ON_DATE'] = 'On';
$lang['myads_ADS_BY'] = 'By';
$lang['myads_STATUS'] = 'Status';
$lang['myads_ACTION'] = 'Actions';
$lang['myads_BDWN_ACTION'] = 'Actions';
$lang['myads_BDWN_DELETE'] = 'Delete Ads';
$lang['myads_BDWN_PREVIEW'] = 'Ad Preview';
$lang['myads_CONDELETE_TEXT'] = 'Are you sure you want to delete this ad? this ad cannot be restored.';
$lang['myads_CONDELETE_SUCCESS'] = 'Your ad has been permanently deleted.';
$lang['myads_CONDELETE_CANCEL'] = 'Thank you, you have just canceled your action.';

// My Files
$lang['myfile_LATEST'] = 'File List';
$lang['myfile_REPORTED'] = 'File Report';
$lang['myfile_POPULAR'] = 'Popular Files';
$lang['myfile_NAME'] = 'File Name';
$lang['myfile_FOLDER'] = 'Folder';
$lang['myfile_SIZE'] = 'Size';
$lang['myfile_TIME'] = 'Uploaded to';
$lang['myfile_DOWNLOADED'] = 'Downloaded';
$lang['myfile_REPORTED'] = 'File Report';
$lang['myfile_UPLOADED_BY'] = 'Uploaded By';
$lang['myfile_ACTION'] = 'Actions';
$lang['myfile_BDWN_ACTION'] = 'Actions';
$lang['myfile_BDWN_DELETE'] = 'Delete File';
$lang['myfile_BDWN_MOVE'] = 'Move to another folder';
$lang['myfile_BDWN_EDIT'] = 'Edit File';
$lang['myfile_BDWN_SEE'] = 'View File';
$lang['myfile_CONDELETE_TEXT'] = 'Are you sure you want to delete this file permanently?';
$lang['myfile_CONDELETE_SUCCESS'] = 'Successfully deleted this file.';
$lang['myfile_CONDELETE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['myfile_CONSEE_TEXT'] = 'Are you sure you want to view this file? this file is safe for you to visit now.';
$lang['myfile_CONSEE_SUCCESS'] = 'Successfully created a secure link for you to visit.';
$lang['myfile_CONSEE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['myfile_CONEDIT_TEXT'] = 'Are you sure you want to edit the information in this file?';
$lang['myfile_CONEDIT_CANCEL'] = 'Thank you, you have just canceled your action.';

// Folder
$lang['folder_DROP_ALL'] = 'Delete folder';
$lang['folder_ADD'] = 'Add Folder';
$lang['folder_TEXT'] = 'Add your file folder. Make sure your folder name does not violate the rules. ';
$lang['folder_CONDROP_TEXT'] = 'Are you sure you want to delete this folder? all files in this folder will also be deleted. ';
$lang['folder_CONDROP_SUCCESS'] = 'Your folder was successfully deleted.';
$lang['folder_CONDROP_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['folder_EDIT'] = 'Edit folder';
$lang['folder_NAME'] = 'Folder Name';
$lang['folder_IFB'] = 'Please enter your folder name!';
$lang['folder_CLEAR'] = 'Clean';
$lang['folder_EMPTY'] = 'Please enter your folder name.';
$lang['folder_INVALID'] = 'Folder names only support the characters a-zA-Z0-9 ._- and spaces.';
$lang['folder_LENGTH'] = 'The name of the folder is 3-30 valid characters.';
$lang['folder_EXISTS'] = 'We do not allow multiple folder names. This folder has been created before. ';
$lang['folder_SUCCESS'] = 'Your folder was successfully created.';
$lang['folder_FAILED'] = 'Your folder failed to create.';
$lang['folder_EDIT_SUCCESS'] = 'The folder has been renamed to';
$lang['folder_EDIT_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['folder_EDIT_FILE'] = 'Edit File';
$lang['folder_EDIT_FILE_TEXT'] = 'Edit your file information including file name, password and file description.';
$lang['folder_EDIT_FILE_NAME'] = 'File Name';
$lang['folder_EDIT_FILE_PASSWORD'] = 'Password';
$lang['folder_EDIT_FILE_DESCRIPTION'] = 'Description';
$lang['folder_EDIT_FILE_IF'] = 'Please enter your file name!';
$lang['folder_EDIT_FILE_BTN'] = 'Save Changes';
$lang['folder_EDIT_FILE_BTNC'] = 'Clean up';
$lang['folder_EDIT_FILE_SS'] = 'File information updated successfully.';
$lang['folder_EDIT_FILE_F'] = 'File information failed to update.';
$lang['folder_CONMOVE_TEXT'] = 'Are you sure you want to move this file to another folder?';
$lang['folder_CONMOVE_CANCEL'] = 'Thank you, you have just canceled your action.';
$lang['folder_MOVE_FILE'] = 'Move file';
$lang['folder_MOVE_TO'] = 'To Folder';
$lang['folder_MOVE_FROM'] = 'From Folder';
$lang['folder_MOVE_FILE_TEXT'] = 'Move your file from the old folder to the new folder. This folder already contains as many files';
$lang['folder_MOVE_FILE_SS'] = 'File moved to folder successfully';
$lang['folder_MOVE_FILE_F'] = 'File failed to move to folder';
$lang['folder_MOVE_SAME'] = 'You cannot move files to the same folder.';

// global
$lang['page'] = 'Page';
$lang['entry'] = 'entry';
$lang['nf'] = 'The data to be displayed is not available right now.';

// 404
$lang['page_NO_RESULT'] = 'The page you are looking for is currently unavailable. Please come again in any other time.';

// User Settings
$lang['userSettings_PASSWORD'] = 'Edit Password';
$lang['userSettings_PROFILE'] = 'Edit Profile';
$lang['userSettings_PASSWORD_TEXT'] = 'For the sake of security of your account, it\'s better to edit your password periodically.';
$lang['userSettings_NEW_PASSWORD'] = 'New Password';
$lang['userSettings_NEW_PASS_IFB'] = 'Please enter your new password!';
$lang['userSettings_CONFIRM_PASSWORD'] = 'Confirm Password';
$lang['userSettings_CONFIRM_PASS_IFB'] = 'Please enter confirm your new password!';
$lang['userSettings_PASSWORD_CLEAR'] = 'Clean up';
$lang['userSettings_PASSWORD_CHANGE'] = 'Save Changes';
$lang['userSettings_PASSWORD_EMPTY'] = 'Please enter your new password.';
$lang['userSettings_PASSWORD_LENGTH'] = 'The minimum length of your password is 8 characters or more.';
$lang['userSettings_PASSWORD_INVALID'] = 'Your passwords do not match. Please confirm your new password again. ';
$lang['userSettings_PASSWORD_SUCCESS'] = 'Your password has been successfully edited. For security reasons, please sign in to your account again. ';
$lang['userSettings_PASSWORD_EXIST'] = 'You are not allowed to use the previous password to use it again as a new password.';
$lang['userSettings_PROFILE_PASSWORD_FAILED'] = 'Your password failed to edit.';
$lang['userSettings_PROFILE_USERNAME'] = 'Username';
$lang['userSettings_PROFILE_FULLNAME'] = 'Full Name';
$lang['userSettings_PROFILE_FULLNAME_IFB'] = 'Please enter your full name!';
$lang['userSettings_PROFILE_EMAIL'] = 'Email';
$lang['userSettings_PROFILE_EMAIL_IFB'] = 'Please enter your email!';
$lang['userSettings_PROFILE_EINV'] = 'Invalid email format!';
$lang['userSettings_PROFILE_DESCRIPTION'] = 'BIO';
$lang['userSettings_PROFILE_DESCRIPTION_IFB'] = 'Please tell us a little about you!';
$lang['userSettings_PROFILE_TEXT'] = 'Edit your profile like full name, email and so on.';
$lang['userSettings_PROFILE_CLEAR'] = 'Clean up';
$lang['userSettings_PROFILE_SAVE'] = 'Save Changes';
$lang['userSettings_PROFILE_NATCU'] = 'We do not allow changing user names for all users.';
$lang['userSettings_PROFILE_ED'] = 'Please fill in all necessary data.';
$lang['userSettings_PROFILE_LOFN'] = 'Full name must contain at least 3-30 valid characters.';
$lang['userSettings_PROFILE_LOE'] = 'Email contains at least 8-30 valid characters.';
$lang['userSettings_PROFILE_LOD'] = 'BIO only supports 2048 characters. HTML support. ';
$lang['userSettings_PROFILE_S'] = 'Your profile was successfully updated.';
$lang['userSettings_PROFILE_F'] = 'Your profile failed to update.';
$lang['userSettings_PROFILE_IFN'] = 'Your full name is incorrect.';
$lang['userSettings_AVATAR'] = 'Edit Avatar';
$lang['userSettings_AVATAR_TEXT'] = 'Edit your avatar easily here.';
$lang['userSettings_AVATAR_CF'] = 'Select file';
$lang['userSettings_AVATAR_MS'] = 'The maximum avatar size is 2MB.';
$lang['userSettings_AVATAR_S'] = 'Avatar';
$lang['userSettings_AVATAR_CLEAR'] = 'Clean up';
$lang['userSettings_AVATAR_CHANGE'] = 'Save Changes';
$lang['userSettings_AVATAR_ED'] = 'Please select the file first.';
$lang['userSettings_AVATAR_BS'] = 'The avatar size is too large. A maximum of 2MB. ';
$lang['userSettings_AVATAR_IE'] = 'Only supports JPG and PNG avatar formats.';
$lang['userSettings_AVATAR_SUCCESS'] = 'Your avatar has been successfully edited.';
$lang['userSettings_AVATAR_FAILED'] = 'Your avatar failed to edit.';

// User Index
$lang['user_PANEL'] = 'Panel';
$lang['user_REGISTERED'] = 'Registered';
$lang['user_LAST_LOGGED'] = 'Last Login';
$lang['user_ACCOUNT'] = 'Account Status';
$lang['user_STORAGE_USED'] = 'Storage';
$lang['user_TOTAL_FILES'] = 'Total Files';
$lang['user_TOTAL_ADS'] = 'Total Ads';
$lang['user_TOTAL_FILES_DOWNLOADED'] = 'Total Downloads';
$lang['user_BANNED'] = 'Your account has been blocked. Contact us to submit an appeal regarding your account. ';
$lang['user_EMPTY_DESCRIPTION'] = 'Complete your profile <a href="'.base_url().'/user/settings/?view=settings&type=profile">here</a>.';
$lang['user_WELCOME'] = 'Enjoy all the service features that we offer in the sidebar menu available. Enjoy our service. ';

// User Account
$lang['user_DELETE'] = 'Delete Account';
$lang['user_DELETE_TEXT'] = 'Please enter your account password to confirm deletion of your account.';
$lang['user_DELETE_BTN'] = 'Delete Now';
$lang['user_DELETE_IFB'] = 'Please enter your password!';
$lang['user_DELETE_BACK'] = 'BACK';
$lang['user_DELETE_EMPTY'] = 'Please enter your password.';
$lang['user_DELETE_IPASS'] = 'Your password is incorrect.';
$lang['user_DELETE_MA'] = 'You cannot delete yourself because you are the main admin.';
$lang['user_DELETE_SS'] = 'Your account has been permanently deleted.';
$lang['user_DELETE_FS'] = 'Your account failed to be permanently deleted.';
$lang['user_DELETE_DS'] = 'A system error has occurred.';
$lang['user_DELETE_DNA'] = 'Your account has been deleted before.';
$lang['user_DELETE_AGREE'] = 'I agree';
$lang['user_DELETE_AGREE2'] = 'I am aware';

// download file
$lang['file_DOWNLOAD'] = 'Download File';
$lang['file_DOWNLOAD_REPORTED'] = 'You have reported this file. Please wait a few more moments. ';
$lang['file_DOWNLOAD_REPORTED_NY'] = 'Thank you for your report. We will act on your report immediately. ';
$lang['file_DOWNLOAD_REPORTED2'] = 'A system error has occurred.';
$lang['file_DOWNLOAD_REPORTED3'] = 'Report';
$lang['file_DOWNLOAD_WARNING'] = 'This file is entirely the responsibility of the uploader. If there are suspicious files, please immediately report to the Administrator. ';
$lang['file_DOWNLOAD_DETAILS'] = 'File Details';
$lang['file_DOWNLOAD_DESCRIPTION'] = 'Description';
$lang['file_DOWNLOAD_COMMENTS'] = 'Comments';
$lang['file_DOWNLOAD_NAME'] = 'File Name';
$lang['file_DOWNLOAD_SIZE'] = 'Size';
$lang['file_DOWNLOAD_TYPE'] = 'Type';
$lang['file_DOWNLOAD_ARTIST'] = 'Artist';
$lang['file_DOWNLOAD_UA'] = 'Unknown';
$lang['file_DOWNLOAD_DURATION'] = 'Duration';
$lang['file_DOWNLOAD_ALBUM'] = 'Album';
$lang['file_DOWNLOAD_YEAR'] = 'Year';
$lang['file_DOWNLOAD_GENRE'] = 'Genre';
$lang['file_DOWNLOAD_BITRATE'] = 'Bitrate';
$lang['file_DOWNLOAD_UPLOADED'] = 'Uploaded';
$lang['file_DOWNLOAD_BY'] = 'By';
$lang['file_DOWNLOAD_DOWNLOADED'] = 'Downloaded';
$lang['file_DOWNLOAD_VIEW'] = 'Viewed';
$lang['file_DOWNLOAD_DESCRIPTION2'] = 'There is no description for this file.';
$lang['file_DOWNLOAD_UNLOCKED'] = 'Thank you';
$lang['file_DOWNLOAD_LOCKED'] = 'File Locked';
$lang['file_DOWNLOAD_LPH'] = 'Enter Password...';
$lang['file_DOWNLOAD_LS'] = 'Loading...';
$lang['file_DOWNLOAD_WAITING'] = 'Please wait';
$lang['file_DOWNLOAD_SECONDS'] = 'seconds';
$lang['file_DOWNLOAD_PINV'] = 'Your password is incorrect. Please check again! ';
$lang['file_DOWNLOAD_CONFIRM_AYS'] = 'Are you sure?';
$lang['file_DOWNLOAD_CONREP_TEXT'] = 'The file you have reported will be reviewed first. If the file violates the rules, it will be permanently deleted immediately. ';
$lang['file_DOWNLOAD_REPSS'] = 'Loading ...';
$lang['file_DOWNLOAD_REPCANC'] = 'Thank you, you have just canceled your action.';
$lang['file_DOWNLOAD_NHA'] = 'haven\'t posted any ads yet;';
$lang['file_DOWNLOAD_AE'] = 'An error occurred!';
$lang['file_DOWNLOAD_SA'] = 'Sponsored Ads';
$lang['file_DOWNLOAD_DNSB'] = 'Your browser does not support playback of this media. Please upgrade your browser to the latest version. ';
$lang['file_DOWNLOAD_LF'] = 'Recent Files:';
$lang['file_DOWNLOAD_NF'] = 'There are no files.';
$lang['file_DOWNLOAD_SHARE'] = 'Share To';
$lang['file_DOWNLOAD_AC'] = 'Add a comment';


// Premium Ads
$lang['userAds_PREMIUM'] = 'Premium Ads';
$lang['userAds_PREMIUM_PREVIEW'] = 'Ad Preview';
$lang['userAds_PREMIUM_NA'] = 'You don\'t have premium ads yet';
$lang['userAds_PREMIUM_ACTIVE'] = 'Active Until:';
$lang['userAds_PREMIUM_LEFT'] = 'hr';
$lang['userAds_PREMIUM_UA'] = 'Your Ad Unit';
$lang['userAds_PREMIUM_PFIYAU'] = 'Please enter your ad unit!';
$lang['userAds_PREMIUM_LEFT2'] = 'Ad Duration';
$lang['userADS_PREMIUM_CLEAR'] = 'Clean up';
$lang['userADS_PREMIUM_UPDATE'] = 'Update';
$lang['userADS_PREMIUM_CREATE'] = 'Create an Ad';
$lang['userAds_PREMIUM_NOTE'] = '<b> Note: </b>';
$lang['userAds_PREMIUM_NOTE2'] = 'Your premium ad will be placed on a strategic page without random with Admin ads. To activate your ad, please contact ';
$lang['userAds_PREMIUM_EC'] = 'Please enter your ad unit.';
$lang['userAds_PREMIUM_IE'] = 'Ad units only support HTML and JavaScript.';
$lang['userAds_PREMIUM_S'] = 'Your ad has been updated successfully.';
$lang['userAds_PREMIUM_F'] = 'Your ad failed to update.';
$lang['userAds_PREMIUM_E'] = 'The active period of your premium ad has expired on';

// Upgrade Account
$lang['user_UPGRADE_ACCOUNT'] = 'Upgrade Account';
$lang['user_UPGRADE_BENEFITS'] = '<b>Benefits:</b>
  <br/>
  <i class="fas fa-check-circle text-success"></i> Free random ads with Admin ads.
  <br/>
  <i class="fa-check-circle text-success"></i> 2x storage capacity.
  <br/>
  <i class="fa-check-circle text-success"></i> 2x maximum limit per file upload.
  <br/>
  <i class="fas fa-check-circle text-success"></i> Advertisements without approval.
  <br/>
  <i class="fa-check-circle text-success"></i> And various other attractive premium account features.
  <br/>';
$lang['user_UPGRADE_I'] = 'Upgrade your account now to the premium version and get a variety of benefits at a lifetime affordable price.';
$lang['user_UPGRADE_CONFIRM'] = 'Confirm Payment';
$lang['user_UPGRADE_CONFIRM2'] = 'Confirmation of payment will be considered valid only enough to provide proof of payment in the form of a receipt number or payment reference number.';
$lang['user_UPGRADE_CS'] = 'Proof of payment received. Account upgrade request is being checked.';
$lang['user_UPGRADE_CF'] = 'Your proof of payment failed to be confirmed.';
$lang['user_UPGRADE_PROOF'] = 'Proof of Payment';
$lang['user_UPGRADE_CI'] = 'Oops! there is an error.';

// index
$lang['index_WELCOME'] = 'Welcome to';
$lang['index_NO_C'] = 'No files available yet. Be the first to upload the file here.';

// Contact us
$lang['contact_EMAIL'] = 'Need questions about our site or want to advertise? please contact us via email below.';

// Terms of service
$lang['tos'] =' You can upload any file except forbidden files that harm our site. Please understand for the convenience of our community.';
?>