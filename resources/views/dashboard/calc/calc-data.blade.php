<div class="card-body profit-calculator">
    <div class="mb-3">
        <label class="form-label">إجمالي الدخل (ريال)</label>
        <input type="number" min="0" class="form-control" id="total-income" value="0"
            wire:model.live='total_income'>
    </div>

    <div class="mb-3">
        <label class="form-label">إجمالي مستحقات الموظفين (ريال)</label>
        <input type="number" min="0" class="form-control" id="total-salaries" value="0"
            wire:model.live='total_salaries'>
    </div>

    <div class="mb-3">
        <label class="form-label">المصاريف الأخرى (ريال)</label>
        <input type="number" min="0" class="form-control" id="other-expenses" value="0"
            wire:model.live='other_expenses'>
    </div>

    <hr style="background-color: rgba(255,255,255,0.2)">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>صافي الربح:</h5>
        <h3 id="net-profit"> {{ $net_profit }} ريال</h3>
    </div>
</div>
