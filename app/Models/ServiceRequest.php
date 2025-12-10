<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ServiceRequest extends Model
{
     protected $fillable = [
        'customer_id', 'device_id', 'total_cost', 
        'status','technician_id', 'sent_back_notes',
        'assessment_notes', 'unsuccessful_notes', 'assessed_at', 
        'unsuccessful_at', 'sent_back_at',
        'archive_reason', 'archive_notes', 'archived_at', 
        'reassign_notes', 'reassigned_at',

        'additional_fees',
        'additional_fees_notes',
        'additional_fees_added_at',
        'additional_fees_added_by',

         // Payment fields
        'payment_status',
        'amount_paid',
        'paid_at',
        'payment_method',
        'transaction_reference',
    ];

    protected $casts = [
        // Cast to Carbon instance
        'sent_back_at' => 'datetime', 
        'assessed_at' => 'datetime',
        'unsuccessful_at' => 'datetime',
        'archived_at' => 'datetime',
        'reassigned_at' => 'datetime',
        'total_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',

        'additional_fees' => 'decimal:2',
        'additional_fees_added_at' => 'datetime',

        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

        public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

public function issues()
{
    return $this->belongsToMany(DeviceIssue::class, 'issue_service_request', 'service_request_id', 'issue_id')
                ->withPivot('cost')
                ->withTimestamps();
}



public function additionalFeesAddedBy()
{
    return $this->belongsTo(User::class, 'additional_fees_added_by');
}



  //Calculate final cost automatically   
    public function calculateFinalCost()
    {
        $baseCost = $this->total_cost ?? 0;
        $additionalFees = $this->additional_fees ?? 0;
        
        return $baseCost + $additionalFees;
    }

    
     //Check if final cost is set
    public function hasFinalCost()
    {
        return !is_null($this->final_cost);
    }

    //Get display final cost (with fallback)
    public function getDisplayFinalCostAttribute()
    {
        return $this->final_cost ?? $this->calculateFinalCost();
    }
  
     //Scope for completed jobs with final cost
    public function scopeWithFinalCost($query)
    {
        return $query->whereNotNull('final_cost');
    }

    
     //Scope for jobs needing final cost calculation
    public function scopeNeedsFinalCost($query)
    {
        return $query->whereNull('final_cost')
                    ->whereIn('status', ['completed', 'repairing']);
    }



    /**
     * Payment-related methods
     */
    public function getBalanceDueAttribute()
    {
        return max(0, ($this->final_cost ?? 0) - ($this->amount_paid ?? 0));
    }

    public function getPaymentProgressAttribute()
    {
        $finalCost = $this->final_cost ?? 0;
        if ($finalCost <= 0) return 0;
        
        return min(100, (($this->amount_paid ?? 0) / $finalCost) * 100);
    }

    public function isFullyPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function hasPartialPayment()
    {
        return $this->payment_status === 'partial';
    }

    public function isPaymentPending()
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Scope for payment status
     */
    public function scopePaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeUnpaid($query)
    {
        return $query->whereIn('payment_status', ['pending', 'partial']);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
}
