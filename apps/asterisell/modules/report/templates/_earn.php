<?php
use_helper('Asterisell');
$income = $cdr->getIncome();
$cost = $cdr->getCost();
if (is_null($income) || is_null($cost)) {
  echo __("undefined");
} else {
  if ((!is_null($cdr->getIncomeArRateId())) && (!is_null($cdr->getCostArRateId()))) {
    $incomeRate = VariableFrame::$rateCache->getRate($cdr->getIncomeArRateId());
    $costRate = VariableFrame::$rateCache->getRate($cdr->getCostArRateId());
    echo format_for_locale(($income - $cost));
  } else {
    $p = new ArProblem();
    $p->setDuplicationKey("CDR cost - " . $cdr->getId());
    $p->setDescription("CDR with id " . $cdr->getId() . " has cost " . $cost . " and income " . $income . " but has a null IncomeArRateId or CostArRateId.");
    $p->setEffect("CDR is not well rated");
    $p->setProposedSolution("Set to NULL cost and income in order to force a rate of the CDR.");
    ArProblemException::signalProblemWithoutException($p);
    echo "  ";
  }
}
?>