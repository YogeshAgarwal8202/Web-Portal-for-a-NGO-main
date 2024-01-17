<?php
namespace PHPReportMaker12\sss;
?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($pager)) $pager = new NumericPager($Page->StartGroup, $Page->DisplayGroups, $Page->TotalGroups, $Page->GroupRange) ?>
<?php if ($pager->RecordCount > 0 && $pager->Visible) { ?>
<div class="ew-pager">
<div class="ew-numeric-page"><ul class="pagination">
	<?php if ($pager->FirstButton->Enabled) { ?>
	<li class="page-item"><a class="page-link" href="<?php echo CurrentPageName() ?>?start=<?php echo $pager->FirstButton->Start ?>"><?php echo $ReportLanguage->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($pager->PrevButton->Enabled) { ?>
	<li class="page-item"><a class="page-link" href="<?php echo CurrentPageName() ?>?start=<?php echo $pager->PrevButton->Start ?>"><?php echo $ReportLanguage->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($pager->Items as $pagerItem) { ?>
		<li class="page-item<?php if (!$pagerItem->Enabled) { echo " active"; } ?>"><a class="page-link" href="<?php if ($pagerItem->Enabled) { echo CurrentPageName() . "?start=" . $pagerItem->Start; } else { echo "#"; } ?>"><?php echo $pagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($pager->NextButton->Enabled) { ?>
	<li class="page-item"><a class="page-link" href="<?php echo CurrentPageName() ?>?start=<?php echo $pager->NextButton->Start ?>"><?php echo $ReportLanguage->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($pager->LastButton->Enabled) { ?>
	<li class="page-item"><a class="page-link" href="<?php echo CurrentPageName() ?>?start=<?php echo $pager->LastButton->Start ?>"><?php echo $ReportLanguage->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</div>
<?php } ?>
<?php if ($pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($Page->TotalGroups > 0 && !$DashboardReport) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="donation_user_wise">
<select name="<?php echo TABLE_GROUP_PER_PAGE; ?>" class="form-control form-control-sm ew-tooltip" onchange="this.form.submit();">
<option value="1"<?php if ($Page->DisplayGroups == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($Page->DisplayGroups == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($Page->DisplayGroups == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($Page->DisplayGroups == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($Page->DisplayGroups == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($Page->DisplayGroups == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($Page->DisplayGroups == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($Page->DisplayGroups == 50) echo " selected" ?>>50</option>
<option value="ALL"<?php if ($Page->getGroupPerPage() == -1) echo " selected" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
