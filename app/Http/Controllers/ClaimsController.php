<?php

namespace App\Http\Controllers;

use App\Models\ClaimsPerLob;
use App\Models\IntegrationClaim;
use App\Models\IntegrationLog;
use App\Models\MstLob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimsController extends Controller
{
    public function create()
    {
        // Retrieve distinct claim_cause values from the claims_per_lob table
        $claim_list = ClaimsPerLob::query()
            ->select('claim_cause')
            ->distinct()
            ->pluck('claim_cause');
        $lob_list = MstLob::pluck('lob_name');
        return view('create', ['claim_list' => $claim_list, 'lob_list' => $lob_list]);
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'lob' => 'required|string',
            'claim_cause' => 'required|string',
            'claim_qty' => 'required|integer|min:0',
            'period' => 'required|date',
            'claim_value' => 'required|numeric|min:0',
        ]);

        // Store the claim data
        ClaimsPerLob::create([
            'lob' => $request->input('lob'),
            'claim_cause' => $request->input('claim_cause'),
            'claim_qty' => $request->input('claim_qty'),
            'period' => $request->input('period'),
            'claim_value' => $request->input('claim_value'),
        ]);

        return redirect()->route('create')->with('success', 'Claim created successfully!');
    }
    public function home()
    {
        // Fetch all claims data
        $claims = ClaimsPerLob::all()->sortBy('lob');

        // Initialize arrays to hold sums
        $lob_totals = [];
        $grand_totals = ['qty' => 0, 'value' => 0];

        // Calculate sums by LOB
        foreach ($claims as $claim) {
            $lob = $claim->lob;
            if (!isset($lob_totals[$lob])) {
                $lob_totals[$lob] = ['qty' => 0, 'value' => 0];
            }
            $lob_totals[$lob]['qty'] += $claim->claim_qty;
            $lob_totals[$lob]['value'] += $claim->claim_value;

            // Update grand totals
            $grand_totals['qty'] += $claim->claim_qty;
            $grand_totals['value'] += $claim->claim_value;
        }

        // Pass the data to the view
        return view('home', [
            'claims' => $claims,
            'lob_totals' => $lob_totals,
            'grand_totals' => $grand_totals,
        ]);
    }


    public function ViewDBPenampung()
    {
        // Fetch all claims data from the db2 connection
        $claims = IntegrationClaim::all()->sortBy('lob');
        // Initialize arrays to hold sums
        $lob_totals = [];
        $grand_totals = ['qty' => 0, 'value' => 0];

        // Calculate sums by LOB
        foreach ($claims as $claim) {
            $lob = $claim->lob;
            if (!isset($lob_totals[$lob])) {
                $lob_totals[$lob] = ['qty' => 0, 'value' => 0];
            }
            $lob_totals[$lob]['qty'] += $claim->claim_qty;
            $lob_totals[$lob]['value'] += $claim->claim_value;

            // Update grand totals
            $grand_totals['qty'] += $claim->claim_qty;
            $grand_totals['value'] += $claim->claim_value;
        }

        // Pass the data to the view
        return view('homepenampung', [
            'claims' => $claims,
            'lob_totals' => $lob_totals,
            'grand_totals' => $grand_totals,
        ]);
    }
    public function integrate(Request $request)
    {
        DB::beginTransaction();

        try {
            // Fetch data from ClaimsPerLob
            $claims = ClaimsPerLob::all();

            // Track the count of integrated records
            $data_count = 0;

            // Integrate data into IntegrationClaims
            foreach ($claims as $claim) {
                // Find an existing claim or create a new one
                $existingClaim = IntegrationClaim::where('claim_id', $claim->id)->first();
                if ($existingClaim) {
                    // Update existing claim
                    $existingClaim->update([
                        'lob' => $claim->lob,
                        'claim_cause' => $claim->claim_cause,
                        'period' => $claim->period,
                        'claim_qty' => $claim->claim_qty,
                        'claim_value' => $claim->claim_value,
                        'updated_at' => now(),
                    ]);
                } else {
                    // Create a new claim
                    IntegrationClaim::create([
                        'claim_id' => $claim->id,
                        'lob' => $claim->lob,
                        'claim_cause' => $claim->claim_cause,
                        'period' => $claim->period,
                        'claim_qty' => $claim->claim_qty,
                        'claim_value' => $claim->claim_value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $data_count++;
            }

            // Log the integration process with status
            IntegrationLog::create([
                'process_date' => now(),
                'data_count' => $data_count,
                'status' => 'completed',
                'created_at' => now(),
            ]);
            DB::commit();
            // Redirect with success message
            return redirect()->route('homepenampung')->with('success', 'Data integration completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the integration process with failed status
            IntegrationLog::create([
                'process_date' => now(),
                'data_count' => 0,
                'status' => 'failed',
                'created_at' => now(),
            ]);
            // Redirect with error message
            return redirect()->route('homepenampung')->with('error', 'Data integration failed: ' . $e->getMessage());
        }
    }
}
