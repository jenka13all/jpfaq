# jpfaq
Jacco van der Post's TYPO3 jpfaq extension, updated so that it can also be used in TYPO3 7. This version is compatible with TYPO3 versions 6.2 - 7.6.9.

##Chages made to the original jpfaq extension##
1. Correction of namspaces that caused errors in TYPO3 7 due to inconsistency, for example "JpFaq" instead of "Jpfaq"
2. Update of how the wizards are added in TCA configuration
3. Update of how the plugin category selection is defined in the Flexform
4. Update of how Flash Messages are added in the controllers
6. Removal of PHP end tags

##How to use extension in your TYPO3 installation##
Because I find the original instructions less than clear, here are some that I rewrote:

###Installation###

1. In your TYPO3 Extension Manager, upload the jpfaq zip file. Make sure to check the box "Overwrite" if you already have jpfaq (v 3.0.0) installed.

2. Once this is done, click on the "Template" module in the left-hand navigation while you are on your root page.

3. Click the button "Edit the whole template record".

4. Click on the "Includes" tab.

5. On the list "Available items" on the right-hand side, you should see an entry for "jpFAQ (jpfaq)". Click on this to include it into your root template. Save and close.

###Adding and editing FAQs###
1. Create a new page for your FAQ records, for example, as a child page to the page you want to show your FAQs on in the frontend.

2. Select the "List" module in the left-hand navigation. Now click on the the "Add a new record" icon in the page. Select from the list either "jpFAQ Question" or "jpFAQ Category" and save. You will now be able to add records for categories and questions, as well as choose categories for an entered question.

3. Select the page you want your FAQs to show up on. Make sure you have selected the "Page" module in the left-hand navigation. Click on "add a new record at this place" icon with the section where you want your content to show up. Click on the "Plugins" tab and select "General Plugin".

4. Select the "Plugin" tag and choose "jpFAQ". Under "Choose page or folder with records", select the page that you created and populated with records in Step 2.

5. Save and close and, of course, clear your caches in the backend before refreshing the frontend to check the results.

6. If you want to change the styles of how your FAQs show up in the front end, you need to edit the file Resources/Public/Css/jpfaq.css
