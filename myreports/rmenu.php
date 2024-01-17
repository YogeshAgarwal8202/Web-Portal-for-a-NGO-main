<?php
namespace PHPReportMaker12\sss;
?>
<?php
namespace PHPReportMaker12\sss;

// Menu Language
if ($Language && $Language->LanguageFolder == $LANGUAGE_FOLDER)
	$MenuLanguage = &$Language;
else
	$MenuLanguage = new Language();

// Navbar menu
$topMenu = new Menu("navbar", TRUE, TRUE);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", TRUE, FALSE);
$sideMenu->addMenuItem(8, "mi_feedback_event_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("8", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "feedback_event_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(10, "mi_event_registration_event_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("10", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "event_registration_event_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(11, "mi_event_registration_user_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("11", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "event_registration_user_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(13, "mi_event_registration_present_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("13", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "event_registration_present_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(14, "mi_donation_user_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("14", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "donation_user_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(16, "mi_event_status_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("16", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "event_status_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(17, "mi_event_date_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("17", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "event_date_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(19, "mi_event_category_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("19", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "event_category_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(20, "mi_donation_method_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("20", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "donation_method_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(21, "mi_donation_gender_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("21", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "donation_gender_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(22, "mi_feedback_user_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("22", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "feedback_user_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(23, "mi_team_member_role_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("23", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "team_member_role_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(25, "mi_volunteer_event_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("25", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "volunteer_event_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(26, "mi_user_type_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("26", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "user_type_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(27, "mi_user_gender_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("27", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "user_gender_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(28, "mi_user_blood_group_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("28", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "user_blood_group_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(29, "mi_user_preferred_category_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("29", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "user_preferred_category_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(30, "mi_donation_date_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("30", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "donation_date_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(31, "mi_feedback_date_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("31", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "feedback_date_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(32, "mi_donation_amount_wise", $ReportLanguage->phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->menuPhrase("32", "MenuText") . $ReportLanguage->phrase("SimpleReportMenuItemSuffix"), "donation_amount_wiserpt.php", -1, "", TRUE, FALSE, FALSE, "", "", FALSE);
echo $sideMenu->toScript();
?>