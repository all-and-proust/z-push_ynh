<?php
/***********************************************
* File      :   config.php
* Project   :   Z-Push
* Descr     :   Main configuration file
*
* Created   :   01.10.2007
*
* Copyright 2007 - 2016 Zarafa Deutschland GmbH
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* Consult LICENSE file for details
************************************************/

/**********************************************************************************
 *  Default settings
 */
    // Defines the default time zone, change e.g. to "Europe/London" if necessary
    define('TIMEZONE', '__TIMEZONE__');

    // Defines the base path on the server
    define('BASE_PATH', dirname($_SERVER['SCRIPT_FILENAME']). '/');

    // Try to set unlimited timeout
    define('SCRIPT_TIMEOUT', 0);

    // Use a custom header to determinate the remote IP of a client.
    // By default, the server provided REMOTE_ADDR is used. If the header here set
    // is available, the provided value will be used, else REMOTE_ADDR is maintained.
    // set to false to disable this behaviour.
    // common values: 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP' (casing is ignored)
    define('USE_CUSTOM_REMOTE_IP_HEADER', false);

    // When using client certificates, we can check if the login sent matches the owner of the certificate.
    // This setting specifies the owner parameter in the certificate to look at.
    define("CERTIFICATE_OWNER_PARAMETER", "SSL_CLIENT_S_DN_CN");

    /*
     * Whether to use the complete email address as a login name
     * (e.g. user@company.com) or the username only (user).
     * This is required for Z-Push to work properly after autodiscover.
     * Possible values:
     *   false - use the username only.
     *   true  - string the mobile sends as username, e.g. full email address (default).
     */
    define('USE_FULLEMAIL_FOR_LOGIN', false);

/**********************************************************************************
 * StateMachine setting
 *
 * These StateMachines can be used:
 *   FILE  - FileStateMachine (default). Needs STATE_DIR set as well.
 *   SQL   - SqlStateMachine has own configuration file. STATE_DIR is ignored.
 *           State migration script is available, more informations: https://wiki.z-hub.io/x/xIAa
 */
    define('STATE_MACHINE', 'FILE');
    define('STATE_DIR', '__STATEDIR__/');

/**********************************************************************************
 *  IPC - InterProcessCommunication
 *
 *  Is either provided by using shared memory on a single host or
 *  using the memcache provider for multi-host environments.
 *  When another implementation should be used, the class can be set here explicitly.
 *  If empty Z-Push will try to use available providers.

 *  Possible values:
 *  IpcSharedMemoryProvider - default. Requires z-push-ipc-sharedmemory package.
 *  IpcMemcachedProvider    - requires z-push-ipc-memcached package. It is necessary to set up
 *                            memcached server before (it won't be installed by z-push-ipc-memcached).
 *  IpcWincacheProvider     - for windows systems.
 */
    define('IPC_PROVIDER', '');

/**********************************************************************************
 *  Logging settings
 *
 *  The LOGBACKEND specifies where the logs are sent to.
 *  Either to file ("filelog") or to a "syslog" server or a custom log class in core/log/logclass.
 *  filelog and syslog have several options that can be set below.
 *  For more information about the syslog configuration, see https://wiki.z-hub.io/x/HIAT

 *  Possible LOGLEVEL and LOGUSERLEVEL values are:
 *  LOGLEVEL_OFF            - no logging
 *  LOGLEVEL_FATAL          - log only critical errors
 *  LOGLEVEL_ERROR          - logs events which might require corrective actions
 *  LOGLEVEL_WARN           - might lead to an error or require corrective actions in the future
 *  LOGLEVEL_INFO           - usually completed actions
 *  LOGLEVEL_DEBUG          - debugging information, typically only meaningful to developers
 *  LOGLEVEL_WBXML          - also prints the WBXML sent to/from the device
 *  LOGLEVEL_DEVICEID       - also prints the device id for every log entry
 *  LOGLEVEL_WBXMLSTACK     - also prints the contents of WBXML stack
 *
 *  The verbosity increases from top to bottom. More verbose levels include less verbose
 *  ones, e.g. setting to LOGLEVEL_DEBUG will also output LOGLEVEL_FATAL, LOGLEVEL_ERROR,
 *  LOGLEVEL_WARN and LOGLEVEL_INFO level entries.
 *
 *  LOGAUTHFAIL is logged to the LOGBACKEND.
 */
    define('LOGBACKEND', 'filelog');
    define('LOGLEVEL', LOGLEVEL_ERROR);
    define('LOGAUTHFAIL', false);

    // To save e.g. WBXML data only for selected users, add the usernames to the array
    // The data will be saved into a dedicated file per user in the LOGFILEDIR
    // Users have to be encapusulated in quotes, several users are comma separated, like:
    //   $specialLogUsers = array('info@domain.com', 'myusername');
    define('LOGUSERLEVEL', LOGLEVEL_DEVICEID);
    $specialLogUsers = array();

    // Filelog settings
    define('LOGFILEDIR', '__FINAL_LOGPATH__/');
    define('LOGFILE', LOGFILEDIR . 'z-push.log');
    define('LOGERRORFILE', LOGFILEDIR . 'z-push-error.log');

    // Syslog settings
    // false will log to local syslog, otherwise put the remote syslog IP here
    define('LOG_SYSLOG_HOST', false);
    // Syslog port
    define('LOG_SYSLOG_PORT', 514);
    // Program showed in the syslog. Useful if you have more than one instance login to the same syslog
    define('LOG_SYSLOG_PROGRAM', 'z-push');
    // Syslog facility - use LOG_USER when running on Windows
    define('LOG_SYSLOG_FACILITY', LOG_LOCAL0);

    // Location of the trusted CA, e.g. '/etc/ssl/certs/EmailCA.pem'
    // Uncomment and modify the following line if the validation of the certificates fails.
    // define('CAINFO', '/etc/ssl/certs/EmailCA.pem');

/**********************************************************************************
 *  Mobile settings
 */
    // Device Provisioning
    define('PROVISIONING', true);

    // This option allows the 'loose enforcement' of the provisioning policies for older
    // devices which don't support provisioning (like WM 5 and HTC Android Mail) - dw2412 contribution
    // false (default) - Enforce provisioning for all devices
    // true - allow older devices, but enforce policies on devices which support it
    define('LOOSE_PROVISIONING', false);

    // The file containing the policies' settings.
    // Set a full path or relative to the z-push main directory
    define('PROVISIONING_POLICYFILE', 'policies.ini');

    // Default conflict preference
    // Some devices allow to set if the server or PIM (mobile)
    // should win in case of a synchronization conflict
    //   SYNC_CONFLICT_OVERWRITE_SERVER - Server is overwritten, PIM wins
    //   SYNC_CONFLICT_OVERWRITE_PIM    - PIM is overwritten, Server wins (default)
    define('SYNC_CONFLICT_DEFAULT', SYNC_CONFLICT_OVERWRITE_PIM);

    // Global limitation of items to be synchronized
    // The mobile can define a sync back period for calendar and email items
    // For large stores with many items the time period could be limited to a max value
    // If the mobile transmits a wider time period, the defined max value is used
    // Applicable values:
    //   SYNC_FILTERTYPE_ALL (default, no limitation)
    //   SYNC_FILTERTYPE_1DAY, SYNC_FILTERTYPE_3DAYS, SYNC_FILTERTYPE_1WEEK, SYNC_FILTERTYPE_2WEEKS,
    //   SYNC_FILTERTYPE_1MONTH, SYNC_FILTERTYPE_3MONTHS, SYNC_FILTERTYPE_6MONTHS
    define('SYNC_FILTERTIME_MAX', SYNC_FILTERTYPE_ALL);

    // Interval in seconds before checking if there are changes on the server when in Ping.
    // It means the highest time span before a change is pushed to a mobile. Set it to
    // a higher value if you have a high load on the server.
    define('PING_INTERVAL', 30);

    // Set the fileas (save as) order for contacts in the webaccess/webapp/outlook.
    // It will only affect new/modified contacts on the mobile which then are synced to the server.
    // Possible values are:
    // SYNC_FILEAS_FIRSTLAST    - fileas will be "Firstname Middlename Lastname"
    // SYNC_FILEAS_LASTFIRST    - fileas will be "Lastname, Firstname Middlename"
    // SYNC_FILEAS_COMPANYONLY  - fileas will be "Company"
    // SYNC_FILEAS_COMPANYLAST  - fileas will be "Company (Lastname, Firstname Middlename)"
    // SYNC_FILEAS_COMPANYFIRST - fileas will be "Company (Firstname Middlename Lastname)"
    // SYNC_FILEAS_LASTCOMPANY  - fileas will be "Lastname, Firstname Middlename (Company)"
    // SYNC_FILEAS_FIRSTCOMPANY - fileas will be "Firstname Middlename Lastname (Company)"
    // The company-fileas will only be set if a contact has a company set. If one of
    // company-fileas is selected and a contact doesn't have a company set, it will default
    // to SYNC_FILEAS_FIRSTLAST or SYNC_FILEAS_LASTFIRST (depending on if last or first
    // option is selected for company).
    // If SYNC_FILEAS_COMPANYONLY is selected and company of the contact is not set
    // SYNC_FILEAS_LASTFIRST will be used
    define('FILEAS_ORDER', SYNC_FILEAS_LASTFIRST);

    // Maximum amount of items to be synchronized per request.
    // Normally this value is requested by the mobile. Common values are 5, 25, 50 or 100.
    // Exporting too much items can cause mobile timeout on busy systems.
    // Z-Push will use the lowest provided value, either set here or by the mobile.
    // MS Outlook 2013+ request up to 512 items to accelerate the sync process.
    // If you detect high load (also on subsystems) you could try a lower setting.
    // max: 512 - value used if mobile does not limit amount of items
    define('SYNC_MAX_ITEMS', 512);

    // The devices usually send a list of supported properties for calendar and contact
    // items. If a device does not includes such a supported property in Sync request,
    // it means the property's value will be deleted on the server.
    // However some devices do not send a list of supported properties. It is then impossible
    // to tell if a property was deleted or it was not set at all if it does not appear in Sync.
    // This parameter defines Z-Push behaviour during Sync if a device does not issue a list with
    // supported properties.
    // See also https://jira.z-hub.io/browse/ZP-302.
    // Possible values:
    // false - do not unset properties which are not sent during Sync (default)
    // true  - unset properties which are not sent during Sync
    define('UNSET_UNDEFINED_PROPERTIES', false);

    // ActiveSync specifies that a contact photo may not exceed 48 KB. This value is checked
    // in the semantic sanity checks and contacts with larger photos are not synchronized.
    // This limitation is not being followed by the ActiveSync clients which set much bigger
    // contact photos. You can override the default value of the max photo size.
    // default: 5242880 - 5 MB default max photo size in bytes
    define('SYNC_CONTACTS_MAXPICTURESIZE', 5242880);

    // Over the WebserviceUsers command it is possible to retrieve a list of all
    // known devices and users on this Z-Push system. The authenticated user needs to have
    // admin rights and a public folder must exist.
    // In multicompany environments this enable an admin user of any company to retrieve
    // this full list, so this feature is disabled by default. Enable with care.
    define('ALLOW_WEBSERVICE_USERS_ACCESS', false);

    // Users with many folders can use the 'partial foldersync' feature, where the server
    // actively stops processing the folder list if it takes too long. Other requests are
    // then redirected to the FolderSync to synchronize the remaining items.
    // Device compatibility for this procedure is not fully understood.
    // NOTE: THIS IS AN EXPERIMENTAL FEATURE WHICH COULD PREVENT YOUR MOBILES FROM SYNCHRONIZING.
    define('USE_PARTIAL_FOLDERSYNC', false);

    // The minimum accepted time in second that a ping command should last.
    // It is strongly advised to keep this config to false. Some device
    // might not be able to send a higher value than the one specificied here and thus
    // unable to start a push connection.
    // If set to false, there will be no lower bound to the ping lifetime.
    // The minimum accepted value is 1 second. The maximum accepted value is 3540 seconds (59 minutes).
    define('PING_LOWER_BOUND_LIFETIME', false);

    // The maximum accepted time in second that a ping command should last.
    // If set to false, there will be no higher bound to the ping lifetime.
    // The minimum accepted value is 1 second. The maximum accepted value is 3540 seconds (59 minutes).
    define('PING_HIGHER_BOUND_LIFETIME', false);

    // Maximum response time
    // Mobiles implement different timeouts to their TCP/IP connections. Android devices for example
    // have a hard timeout of 30 seconds. If the server is not able to answer a request within this timeframe,
    // the answer will not be recieved and the device will send a new one overloading the server.
    // There are three categories
    //   - Short timeout  - server has up within 30 seconds - is automatically applied for not categorized types
    //   - Medium timeout - server has up to 90 seconds to respond
    //   - Long timeout   - server has up to 4 minutes to respond
    // If a timeout is almost reached the server will break and sent the results it has until this
    // point. You can add DeviceType strings to the categories.
    // In general longer timeouts are better, because more data can be streamed at once.
    define('SYNC_TIMEOUT_MEDIUM_DEVICETYPES', "SAMSUNGGTI");
    define('SYNC_TIMEOUT_LONG_DEVICETYPES',   "iPod, iPad, iPhone, WP, WindowsOutlook, WindowsMail");

    // Time in seconds the device should wait whenever the service is unavailable,
    // e.g. when a backend service is unavailable.
    // Z-Push sends a "Retry-After" header in the response with the here defined value.
    // It is up to the device to respect or not this directive so even if this option is set,
    // the device might not wait requested time frame.
    // Number of seconds before retry, to disable set to: false
    define('RETRY_AFTER_DELAY', 300);

/**********************************************************************************
 *  Backend settings
 */
    // the backend data provider
    define('BACKEND_PROVIDER', '__BACKEND__');

/**********************************************************************************
 *  Search provider settings
 *
 *  Alternative backend to perform SEARCH requests (GAL search)
 *  By default the main Backend defines the preferred search functionality.
 *  If set, the Search Provider will always be preferred.
 *  Use 'BackendSearchLDAP' to search in a LDAP directory (see backend/searchldap/config.php)
 */
    define('SEARCH_PROVIDER', 'BackendSearchLDAP');
    // Time in seconds for the server search. Setting it too high might result in timeout.
    // Setting it too low might not return all results. Default is 10.
    define('SEARCH_WAIT', 10);
    // The maximum number of results to send to the client. Setting it too high
    // might result in timeout. Default is 10.
    define('SEARCH_MAXRESULTS', 10);

/**********************************************************************************
 *  Kopano Outlook Extension - Settings
 *
 *  The Kopano Outlook Extension (KOE) provides MS Outlook 2013 and newer with
 *  functionality not provided by ActiveSync or not implemented by Outlook.
 *  For more information, see: https://wiki.z-hub.io/x/z4Aa
 */
    // Global Address Book functionality
    define('KOE_CAPABILITY_GAB', true);
    // Synchronize mail flags from the server to Outlook/KOE
    define('KOE_CAPABILITY_RECEIVEFLAGS', true);
    // Encode flags when sending from Outlook/KOE
    define('KOE_CAPABILITY_SENDFLAGS', true);
    // Out-of-office support
    define('KOE_CAPABILITY_OOF', true);
    // Out-of-office support with start & end times (superseeds KOE_CAPABILITY_OOF)
    define('KOE_CAPABILITY_OOFTIMES', true);
    // Notes support
    define('KOE_CAPABILITY_NOTES', true);
    // Shared folder support
    define('KOE_CAPABILITY_SHAREDFOLDER', true);
    // Send-As support for Outlook/KOE and mobiles
    define('KOE_CAPABILITY_SENDAS', true);
    // Secondary Contact folders (own and shared)
    define('KOE_CAPABILITY_SECONDARYCONTACTS', true);
    // Copy WebApp signature into KOE
    define('KOE_CAPABILITY_SIGNATURES', true);
    // Delivery receipt requests
    define('KOE_CAPABILITY_RECEIPTS', true);
    // Impersonate other users
    define('KOE_CAPABILITY_IMPERSONATE', true);

    // To synchronize the GAB KOE, the GAB store and folderid need to be specified.
    // Use the gab-sync script to generate this data. The name needs to
    // match the config of the gab-sync script.
    // More information here: https://wiki.z-hub.io/x/z4Aa (GAB Sync Script)
    define('KOE_GAB_STORE', 'SYSTEM');
    define('KOE_GAB_FOLDERID', '');
    define('KOE_GAB_NAME', 'Z-Push-KOE-GAB');

/**********************************************************************************
 *  Synchronize additional folders to all mobiles
 *
 *  With this feature, special folders can be synchronized to all mobiles.
 *  This is useful for e.g. global company contacts.
 *
 *  This feature is supported only by certain devices, like iPhones.
 *  Check the compatibility list for supported devices:
 *      http://z-push.org/compatibility
 *
 *  To synchronize a folder, add a section setting all parameters as below:
 *      store:      the ressource where the folder is located.
 *                  Kopano users use 'SYSTEM' for the 'Public Folder'
 *      folderid:   folder id of the folder to be synchronized
 *      name:       name to be displayed on the mobile device
 *      type:       supported types are:
 *                      SYNC_FOLDER_TYPE_USER_CONTACT
 *                      SYNC_FOLDER_TYPE_USER_APPOINTMENT
 *                      SYNC_FOLDER_TYPE_USER_TASK
 *                      SYNC_FOLDER_TYPE_USER_MAIL
 *                      SYNC_FOLDER_TYPE_USER_NOTE
 *      flags:      sets additional options on the shared folder. Supported are:
 *                      DeviceManager::FLD_FLAGS_NONE
 *                          No flags configured, default flag to be set
 *                      DeviceManager::FLD_FLAGS_SENDASOWNER
 *                          When replying in this folder, automatically do Send-As
 *                      DeviceManager::FLD_FLAGS_CALENDARREMINDERS
 *                          If set, Outlook shows reminders for these shares with KOE
 *                      DeviceManager::FLD_FLAGS_NOREADONLYNOTIFY
 *                          If set, Z-Push won't send notification emails for changes
 *                          if the folder is read-only
 *
 *  Additional notes:
 *  - on Kopano systems use backend/kopano/listfolders.php script to get a list
 *    of available folders
 *
 *  - all Z-Push users must have at least reading permissions so the configured
 *    folders can be synchronized to the mobile. Else they are ignored.
 *
 *  - this feature is only partly suitable for multi-tenancy environments,
 *    as ALL users from ALL tenents need access to the configured store & folder.
 *    When configuring a public folder, this will cause problems, as each user has
 *    a different public folder in his tenant, so the folder are not available.

 *  - changing this configuration could cause HIGH LOAD on the system, as all
 *    connected devices will be updated and load the data contained in the
 *    added/modified folders.
 */

    $additionalFolders = array(
        // demo entry for the synchronization of contacts from the public folder.
        // uncomment (remove '/*' '*/') and fill in the folderid
/*
        array(
            'store'     => "SYSTEM",
            'folderid'  => "",
            'name'      => "Public Contacts",
            'type'      => SYNC_FOLDER_TYPE_USER_CONTACT,
            'flags'     => DeviceManager::FLD_FLAGS_NONE,
        ),
*/
    );
