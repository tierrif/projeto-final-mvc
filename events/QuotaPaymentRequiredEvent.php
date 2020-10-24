<?

class QuotaPaymentRequiredEvent implements Event {
    private $_quotaId; // int.
    private $_value; // float.
    private $_lastPaymentDate; // date.
    private $_paymentDueDate; // date.
    private $_memberId; // int.

    public function __construct($quotaId, $value, $lastPaymentDate, $paymentDueDate, $memberId) {
        $this->_quotaId = $quotaId;
        $this->_value = $value;
        $this->_lastPaymentDate = $lastPaymentDate;
        $this->_paymentDueDate = $paymentDueDate;
        $this->_memberId = $memberId;
    }

    public function getType() {
        return 'QuotaPaymentRequired';
    }

    public function getQuotaId() {
        return $this->_quotaId;
    }

    public function getValue() {
        return $this->_value;
    }

    public function getLastPaymentDate() {
        return $this->_lastPaymentDate;
    }

    public function getPaymentDueDate() {
        return $this->_paymentDueDate;
    }

    public function getMemberId() {
        return $this->_memberId;
    }
}