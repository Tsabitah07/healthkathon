@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div>
            <h4 class="fw-bold">Function Selection</h4>
            <div class="input-group has-validation">
                <span class="input-group-text" style="width: 170px">Chaincode Function</span>
                <select class="form-select claim_type" aria-label="Claim Type" id="claim_type" required>
                    <option value="1">Issue Card</option>
                    <option value="2">Verify Card</option>
                    <option value="3">Record Visit</option>
                    <option value="4">Get Patient Visit</option>
                    <option value="5">Create Referral</option>
                    <option value="6">Update Referral Status</option>
                    <option value="7">Submit Claim</option>
                    <option value="8">Process Claim</option>
                    <option value="9">Get Patient Claim</option>
                    <option value="10">Query Audit Logs</option>
                </select>
            </div>
            <div class="d-flex flex-column gap-2 mt-3 p-3" style="width: 80vw; border: 1px solid #ccc; border-radius: 10px;">
                <p class="p-0 m-0">Function Info</p>
                <h5 class="m-0 p-0">function: Function Name</h5>
                <p class="m-0 p-0">Required Arguments: </p>
                <ul>
                    <li>arg1</li>
                    <li>arg2</li>
                    <li>arg3</li>
                </ul>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Function Arguments [JSON Array]</h4>
            <pre class="p-3 bg-dark text-white" style="width: 80vw; border: 1px solid #ccc; border-radius: 10px; overflow: auto;">
                [
                    "arg1_value",
                    "arg2_value",
                    "arg3_value"
                ]</pre>
            <button class="btn btn-primary mt-1">Load Example Arguments</button>
        </div>

        <div>
            <h4 class="fw-bold">Chaincode Response</h4>
            <div class="d-flex flex-row justify-content-start align-items-center py-2 mb-2 gap-4">
                <button class="btn btn-success">Invoke Function [Write]</button>
                <button class="btn btn-info">Query Response [Read]</button>
            </div>
            <pre class="p-3 bg-dark text-white" style="width: 80vw; border: 1px solid #ccc; border-radius: 10px; overflow: auto;">
                {
                    "status": "success",
                    "data": {
                        "key1": "value1",
                        "key2": "value2",
                        "key3": "value3"
                    },
                    "message": "Function executed successfully."
                }</pre>
        </div>
    </div>
@endsection
