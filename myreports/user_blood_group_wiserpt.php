<?php
namespace PHPReportMaker12\sss;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start();

// Autoload
include_once "rautoload.php";
?>
<?php

// Create page object
if (!isset($user_blood_group_wise_rpt))
	$user_blood_group_wise_rpt = new user_blood_group_wise_rpt();
if (isset($Page))
	$OldPage = $Page;
$Page = &$user_blood_group_wise_rpt;

// Run the page
$Page->run();

// Setup login status
SetClientVar("login", LoginStatus());
if (!$DashboardReport)
	WriteHeader(FALSE);

// Global Page Rendering event (in rusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php if (!$DashboardReport) { ?>
<?php include_once "rheader.php" ?>
<?php } ?>
<?php if ($Page->Export == "" || $Page->Export == "print") { ?>
<script>
currentPageID = ew.PAGE_ID = "rpt"; // Page ID
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<script>

// Form object
var fuser_blood_group_wiserpt = currentForm = new ew.Form("fuser_blood_group_wiserpt");

// Validate method
fuser_blood_group_wiserpt.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj), elm;

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fuser_blood_group_wiserpt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}
<?php if (CLIENT_VALIDATE) { ?>
fuser_blood_group_wiserpt.validateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fuser_blood_group_wiserpt.validateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fuser_blood_group_wiserpt.lists["x_user_blood_group"] = <?php echo $user_blood_group_wise_rpt->user_blood_group->Lookup->toClientList() ?>;
fuser_blood_group_wiserpt.lists["x_user_blood_group"].options = <?php echo JsonEncode($user_blood_group_wise_rpt->user_blood_group->lookupOptions()) ?>;
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<a id="top"></a>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-container" class="container-fluid ew-container">
<?php } ?>
<?php if (ReportParam("showfilter") === TRUE) { ?>
<?php $Page->showFilterList(TRUE) ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->render("body");
	$Page->SearchOptions->render("body");
	$Page->FilterOptions->render("body");
	$Page->GenerateOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php $Page->showMessage(); ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
<!-- Center Container - Report -->
<div id="ew-center" class="<?php echo $user_blood_group_wise_rpt->CenterContentClass ?>">
<?php } ?>
<!-- Summary Report begins -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<!-- Search form (begin) -->
<?php

	// Render search row
	$Page->resetAttributes();
	$Page->RowType = ROWTYPE_SEARCH;
	$Page->renderRow();
?>
<form name="fuser_blood_group_wiserpt" id="fuser_blood_group_wiserpt" class="form-inline ew-form ew-ext-filter-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($Page->Filter <> "") ? " show" : " show"; ?>
<div id="fuser_blood_group_wiserpt-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ew-row d-sm-flex">
<div id="c_user_blood_group" class="ew-cell form-group">
	<label for="x_user_blood_group" class="ew-search-caption ew-label"><?php echo $Page->user_blood_group->caption() ?></label>
	<span class="ew-search-field">
<?php $Page->user_blood_group->EditAttrs["onchange"] = "ew.forms(this).submit(); " . @$Page->user_blood_group->EditAttrs["onchange"]; ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="user_blood_group_wise" data-field="x_user_blood_group" data-value-separator="<?php echo $Page->user_blood_group->displayValueSeparatorAttribute() ?>" id="x_user_blood_group" name="x_user_blood_group"<?php echo $Page->user_blood_group->editAttributes() ?>>
		<?php echo $Page->user_blood_group->selectOptionListHtml("x_user_blood_group") ?>
	</select>
</div>
<?php echo $Page->user_blood_group->Lookup->getParamTag("p_x_user_blood_group") ?>
</span>
</div>
</div>
</div>
</form>
<script>
fuser_blood_group_wiserpt.filterList = <?php echo $Page->getFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGroup = $Page->TotalGroups;
} else {
	$Page->StopGroup = $Page->StartGroup + $Page->DisplayGroups - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGroup) > intval($Page->TotalGroups))
	$Page->StopGroup = $Page->TotalGroups;
$Page->RecordCount = 0;
$Page->RecordIndex = 0;

// Get first row
if ($Page->TotalGroups > 0) {
	$Page->loadRowValues(TRUE);
	$Page->GroupCount = 1;
}
$Page->GroupIndexes = InitArray(2, -1);
$Page->GroupIndexes[0] = -1;
$Page->GroupIndexes[1] = $Page->StopGroup - $Page->StartGroup + 1;
while ($Page->Recordset && !$Page->Recordset->EOF && $Page->GroupCount <= $Page->DisplayGroups || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="card ew-card ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_user_blood_group_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ew-table-header">
<?php if ($Page->user_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_id"><div class="user_blood_group_wise_user_id"><span class="ew-table-header-caption"><?php echo $Page->user_id->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_id">
<?php if ($Page->sortUrl($Page->user_id) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_id">
			<span class="ew-table-header-caption"><?php echo $Page->user_id->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_id" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_id) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_id->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_id->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_id->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->type_name->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="type_name"><div class="user_blood_group_wise_type_name"><span class="ew-table-header-caption"><?php echo $Page->type_name->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="type_name">
<?php if ($Page->sortUrl($Page->type_name) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_type_name">
			<span class="ew-table-header-caption"><?php echo $Page->type_name->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_type_name" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->type_name) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->type_name->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->type_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->type_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_name->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_name"><div class="user_blood_group_wise_user_name"><span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_name">
<?php if ($Page->sortUrl($Page->user_name) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_name">
			<span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_name" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_name) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_gender->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_gender"><div class="user_blood_group_wise_user_gender"><span class="ew-table-header-caption"><?php echo $Page->user_gender->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_gender">
<?php if ($Page->sortUrl($Page->user_gender) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_gender">
			<span class="ew-table-header-caption"><?php echo $Page->user_gender->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_gender" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_gender) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_gender->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_gender->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_gender->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_dob->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_dob"><div class="user_blood_group_wise_user_dob"><span class="ew-table-header-caption"><?php echo $Page->user_dob->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_dob">
<?php if ($Page->sortUrl($Page->user_dob) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_dob">
			<span class="ew-table-header-caption"><?php echo $Page->user_dob->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_dob" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_dob) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_dob->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_dob->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_dob->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_email->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_email"><div class="user_blood_group_wise_user_email"><span class="ew-table-header-caption"><?php echo $Page->user_email->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_email">
<?php if ($Page->sortUrl($Page->user_email) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_email">
			<span class="ew-table-header-caption"><?php echo $Page->user_email->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_email" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_email) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_email->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_email->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_email->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_mobile->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_mobile"><div class="user_blood_group_wise_user_mobile"><span class="ew-table-header-caption"><?php echo $Page->user_mobile->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_mobile">
<?php if ($Page->sortUrl($Page->user_mobile) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_mobile">
			<span class="ew-table-header-caption"><?php echo $Page->user_mobile->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_mobile" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_mobile) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_mobile->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_mobile->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_mobile->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_country_code->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_country_code"><div class="user_blood_group_wise_user_country_code"><span class="ew-table-header-caption"><?php echo $Page->user_country_code->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_country_code">
<?php if ($Page->sortUrl($Page->user_country_code) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_country_code">
			<span class="ew-table-header-caption"><?php echo $Page->user_country_code->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_country_code" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_country_code) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_country_code->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_country_code->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_country_code->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_blood_group->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_blood_group"><div class="user_blood_group_wise_user_blood_group"><span class="ew-table-header-caption"><?php echo $Page->user_blood_group->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_blood_group">
<?php if ($Page->sortUrl($Page->user_blood_group) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_blood_group">
			<span class="ew-table-header-caption"><?php echo $Page->user_blood_group->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_blood_group" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_blood_group) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_blood_group->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_blood_group->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_blood_group->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_health_issue->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_health_issue"><div class="user_blood_group_wise_user_health_issue"><span class="ew-table-header-caption"><?php echo $Page->user_health_issue->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_health_issue">
<?php if ($Page->sortUrl($Page->user_health_issue) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_health_issue">
			<span class="ew-table-header-caption"><?php echo $Page->user_health_issue->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_health_issue" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_health_issue) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_health_issue->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_health_issue->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_health_issue->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_location->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_location"><div class="user_blood_group_wise_user_location"><span class="ew-table-header-caption"><?php echo $Page->user_location->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_location">
<?php if ($Page->sortUrl($Page->user_location) == "") { ?>
		<div class="ew-table-header-btn user_blood_group_wise_user_location">
			<span class="ew-table-header-caption"><?php echo $Page->user_location->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer user_blood_group_wise_user_location" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_location) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_location->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_location->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_location->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGroups == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecordCount++;
	$Page->RecordIndex++;
?>
<?php

		// Render detail row
		$Page->resetAttributes();
		$Page->RowType = ROWTYPE_DETAIL;
		$Page->renderRow();
?>
	<tr<?php echo $Page->rowAttributes(); ?>>
<?php if ($Page->user_id->Visible) { ?>
		<td data-field="user_id"<?php echo $Page->user_id->cellAttributes() ?>>
<span<?php echo $Page->user_id->viewAttributes() ?>><?php echo $Page->user_id->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->type_name->Visible) { ?>
		<td data-field="type_name"<?php echo $Page->type_name->cellAttributes() ?>>
<span<?php echo $Page->type_name->viewAttributes() ?>><?php echo $Page->type_name->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_name->Visible) { ?>
		<td data-field="user_name"<?php echo $Page->user_name->cellAttributes() ?>>
<span<?php echo $Page->user_name->viewAttributes() ?>><?php echo $Page->user_name->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_gender->Visible) { ?>
		<td data-field="user_gender"<?php echo $Page->user_gender->cellAttributes() ?>>
<span<?php echo $Page->user_gender->viewAttributes() ?>><?php echo $Page->user_gender->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_dob->Visible) { ?>
		<td data-field="user_dob"<?php echo $Page->user_dob->cellAttributes() ?>>
<span<?php echo $Page->user_dob->viewAttributes() ?>><?php echo $Page->user_dob->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_email->Visible) { ?>
		<td data-field="user_email"<?php echo $Page->user_email->cellAttributes() ?>>
<span<?php echo $Page->user_email->viewAttributes() ?>><?php echo $Page->user_email->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_mobile->Visible) { ?>
		<td data-field="user_mobile"<?php echo $Page->user_mobile->cellAttributes() ?>>
<span<?php echo $Page->user_mobile->viewAttributes() ?>><?php echo $Page->user_mobile->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_country_code->Visible) { ?>
		<td data-field="user_country_code"<?php echo $Page->user_country_code->cellAttributes() ?>>
<span<?php echo $Page->user_country_code->viewAttributes() ?>><?php echo $Page->user_country_code->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_blood_group->Visible) { ?>
		<td data-field="user_blood_group"<?php echo $Page->user_blood_group->cellAttributes() ?>>
<span<?php echo $Page->user_blood_group->viewAttributes() ?>><?php echo $Page->user_blood_group->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_health_issue->Visible) { ?>
		<td data-field="user_health_issue"<?php echo $Page->user_health_issue->cellAttributes() ?>>
<span<?php echo $Page->user_health_issue->viewAttributes() ?>><?php echo $Page->user_health_issue->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_location->Visible) { ?>
		<td data-field="user_location"<?php echo $Page->user_location->cellAttributes() ?>>
<span<?php echo $Page->user_location->viewAttributes() ?>><?php echo $Page->user_location->getViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->accumulateSummary();

		// Get next record
		$Page->loadRowValues();
	$Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="card ew-card ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_user_blood_group_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGroups > 0 || FALSE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php include "user_blood_group_wise_pager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
</div>
<!-- /.ew-container -->
<?php } ?>
<?php
$Page->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php

// Close recordsets
if ($Page->GroupRecordset)
	$Page->GroupRecordset->Close();
if ($Page->Recordset)
	$Page->Recordset->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<script>

// Write your table-specific startup script here
// console.log("page loaded");

</script>
<?php } ?>
<?php if (!$DashboardReport) { ?>
<?php include_once "rfooter.php" ?>
<?php } ?>
<?php
$Page->terminate();
if (isset($OldPage))
	$Page = $OldPage;
?>