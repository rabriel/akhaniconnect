Akhani Connect Jobs WordPress Plugin
===================================

Folder name:
akhaniconnectjobs

Shortcode:
[akhani-connect-jobs]

Setup:
1. Copy the `akhaniconnectjobs` folder into your WordPress `wp-content/plugins/` directory.
2. Open `akhaniconnectjobs.php`.
3. Update the database placeholders in the `databaseConfig()` method:
   - host
   - port
   - name
   - user
   - password
4. Activate the plugin in WordPress.
5. Add the shortcode `[akhani-connect-jobs]` to any page or post.

Notes:
- Jobs are read from the Laravel `jobs` table.
- Only `published` jobs with a non-null `published_at` date are shown.
- Results are paginated at 10 jobs per page with numbered links plus Previous/Next navigation.
- Apply buttons always open:
  https://admin.akhaniconnect.co.za/
- Search filters:
  - Keyword
  - Province
  - Type

Developer:
LMK Digital
https://lmkdigital.africa/
info@lmkdigital.africa
