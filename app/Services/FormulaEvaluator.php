<?php
namespace App\Services;

class FormulaEvaluator
{
    public function evaluate($formula, $variables)
    {
        // Gantikan variabel dalam rumus dengan nilai sebenarnya
        foreach ($variables as $key => $value) {
            // Pastikan nama variabel dalam rumus cocok dengan yang ada di array variables
            $formula = str_replace($key, $value, $formula);
        }

        // Evaluasi rumus dengan aman
        try {
            $result = eval("return ($formula);");
            $result = number_format($result, 2);
        } catch (\Exception $e) {
            return ['error' => 'Invalid formula or variables'];
        }

        return ['result' => $result];
    }
}
