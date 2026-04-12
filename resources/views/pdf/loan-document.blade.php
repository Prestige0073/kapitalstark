<!DOCTYPE html>
<html lang="{{ $locale ?? 'fr' }}">
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 12px;
    color: #1a2540;
    background: #ffffff;
    line-height: 1.65;
}

/* ── Watermark ─────────────────────────────────────────────── */
.watermark {
    position: fixed;
    top: 36%;
    left: 50%;
    transform: translateX(-50%) rotate(-32deg);
    font-size: 88px;
    font-weight: 900;
    color: rgba(38,123,241,0.045);
    letter-spacing: 14px;
    text-transform: uppercase;
    white-space: nowrap;
    z-index: 0;
    pointer-events: none;
}

/* ── Header ────────────────────────────────────────────────── */
.header {
    background: #0a1628;
    padding: 26px 40px;
    display: table;
    width: 100%;
}
.header-left  { display: table-cell; vertical-align: middle; width: 55%; }
.header-right { display: table-cell; vertical-align: middle; text-align: right; }

.logo-wrap      { display: table; }
.logo-cell      { display: table-cell; vertical-align: middle; }
.logo-pdf-kapital {
    font-family: Georgia, serif;
    font-style: italic;
    font-weight: bold;
    font-size: 22px;
    color: #fff;
    letter-spacing: -0.3px;
}
.logo-pdf-sep {
    font-family: Georgia, serif;
    font-size: 18px;
    color: #C8A951;
    padding: 0 6px;
    font-style: normal;
}
.logo-pdf-stark {
    font-family: 'Courier New', Courier, monospace;
    font-weight: bold;
    font-size: 13px;
    color: #A8CFF7;
    text-transform: uppercase;
    letter-spacing: 2.5px;
}
.logo-sub   { color: rgba(255,255,255,0.4); font-size: 9.5px; letter-spacing: 2px; text-transform: uppercase; margin-top: 3px; }

.doc-title  { color: #267BF1; font-size: 15px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
.doc-ref    { color: rgba(255,255,255,0.5); font-size: 10px; margin-top: 5px; letter-spacing: 0.5px; }
.doc-date   { color: rgba(255,255,255,0.4); font-size: 9.5px; margin-top: 3px; }

/* ── Accent bar ────────────────────────────────────────────── */
.accent-bar {
    height: 5px;
    background: linear-gradient(90deg, #267BF1 0%, #1a56db 55%, #0a1628 100%);
}

/* ── Status strip ──────────────────────────────────────────── */
.status-strip {
    display: table;
    width: 100%;
    padding: 12px 40px;
}
.status-strip-offer    { background: rgba(38,123,241,0.07); border-bottom: 1px solid rgba(38,123,241,0.18); }
.status-strip-signed   { background: rgba(16,185,129,0.07); border-bottom: 1px solid rgba(16,185,129,0.2); }
.status-strip-approved { background: rgba(16,185,129,0.07); border-bottom: 1px solid rgba(16,185,129,0.2); }

.status-dot-cell { display: table-cell; vertical-align: middle; width: 16px; }
.status-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    display: inline-block;
}
.status-dot-offer    { background: #267BF1; }
.status-dot-signed   { background: #16a34a; }
.status-dot-approved { background: #16a34a; }

.status-text-cell { display: table-cell; vertical-align: middle; padding-left: 10px; }
.status-label-offer    { font-size: 11px; font-weight: 700; color: #1a56db; }
.status-label-signed   { font-size: 11px; font-weight: 700; color: #15803d; }
.status-label-approved { font-size: 11px; font-weight: 700; color: #15803d; }

/* ── Body container ────────────────────────────────────────── */
.body { padding: 28px 40px 0; position: relative; z-index: 1; }

/* ── Section title ─────────────────────────────────────────── */
.section-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #267BF1;
    border-bottom: 1.5px solid rgba(38,123,241,0.18);
    padding-bottom: 6px;
    margin-bottom: 16px;
    margin-top: 26px;
}
.section-title:first-child { margin-top: 0; }

/* ── Info grid ─────────────────────────────────────────────── */
.info-grid { display: table; width: 100%; margin-bottom: 6px; }
.info-col  { display: table-cell; width: 50%; vertical-align: top; padding-right: 24px; }
.info-col:last-child {
    padding-right: 0;
    padding-left: 24px;
    border-left: 1.5px solid rgba(38,123,241,0.09);
}

.info-row   { margin-bottom: 12px; }
.info-label {
    font-size: 9.5px;
    font-weight: 700;
    color: #8a9bb8;
    text-transform: uppercase;
    letter-spacing: 0.9px;
    margin-bottom: 3px;
}
.info-value { font-size: 13px; font-weight: 600; color: #1a2540; }
.info-value-sm { font-size: 11.5px; font-weight: 600; color: #1a2540; }

/* ── Highlight box ─────────────────────────────────────────── */
.highlight-box {
    background: #f4f7ff;
    border: 1px solid rgba(38,123,241,0.14);
    border-left: 5px solid #267BF1;
    border-radius: 8px;
    padding: 20px 24px;
    margin: 18px 0;
}
.highlight-grid { display: table; width: 100%; }
.highlight-cell {
    display: table-cell;
    text-align: center;
    vertical-align: middle;
    padding: 0 14px;
    border-right: 1px solid rgba(38,123,241,0.12);
}
.highlight-cell:last-child { border-right: none; }
.highlight-label {
    font-size: 9px;
    color: #8a9bb8;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-weight: 700;
    margin-bottom: 6px;
}
.highlight-value {
    font-size: 26px;
    font-weight: 900;
    color: #267BF1;
    font-family: 'Courier New', monospace;
    line-height: 1.1;
}
.highlight-value-sm {
    font-size: 18px;
    font-weight: 700;
    color: #1a2540;
    font-family: 'Courier New', monospace;
    line-height: 1.1;
}
.highlight-sub {
    font-size: 9px;
    color: #8a9bb8;
    margin-top: 4px;
}

/* ── Data table ────────────────────────────────────────────── */
table.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    margin-top: 6px;
}
table.data-table thead tr { background: #0f1e38; }
table.data-table thead th {
    padding: 10px 12px;
    text-align: left;
    font-weight: 700;
    letter-spacing: 0.8px;
    font-size: 9.5px;
    text-transform: uppercase;
    color: #fff;
}
table.data-table thead th:last-child { text-align: right; }
table.data-table tbody tr:nth-child(even) { background: #f8faff; }
table.data-table tbody tr:nth-child(odd)  { background: #fff; }
table.data-table tbody td {
    padding: 9px 12px;
    border-bottom: 1px solid rgba(38,123,241,0.06);
    color: #2a3650;
    vertical-align: middle;
}
table.data-table tbody td:last-child {
    text-align: right;
    font-family: 'Courier New', monospace;
    font-weight: 700;
}
table.data-table tfoot tr { background: rgba(38,123,241,0.07); }
table.data-table tfoot td {
    padding: 10px 12px;
    font-weight: 700;
    border-top: 2px solid rgba(38,123,241,0.22);
    font-size: 11.5px;
}
table.data-table tfoot td:last-child {
    text-align: right;
    color: #267BF1;
}

/* ── Conditions box ────────────────────────────────────────── */
.conditions-box {
    background: #f9fafc;
    border: 1px solid #e5eaf5;
    border-radius: 8px;
    padding: 18px 22px;
    margin: 18px 0;
}
.condition-item { margin-bottom: 12px; }
.condition-item:last-child { margin-bottom: 0; }
.condition-title {
    font-size: 11px;
    font-weight: 700;
    color: #1a2540;
    margin-bottom: 3px;
}
.condition-text {
    font-size: 11px;
    color: #5a6a8a;
    line-height: 1.65;
}

/* ── Signatures ────────────────────────────────────────────── */
.sig-row  { display: table; width: 100%; margin-top: 28px; }
.sig-cell { display: table-cell; width: 33%; padding: 0 14px; vertical-align: top; }
.sig-cell:first-child { padding-left: 0; }
.sig-cell:last-child  { padding-right: 0; }

.sig-box {
    border: 1.5px dashed rgba(38,123,241,0.28);
    border-radius: 8px;
    padding: 24px 14px 12px;
    text-align: center;
    min-height: 80px;
    background: #fafbff;
}
.sig-label {
    font-size: 9px;
    color: #8a9bb8;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-weight: 700;
    margin-top: 12px;
    text-align: center;
}

.stamp-wrap { text-align: center; padding-top: 4px; }
.stamp {
    display: inline-block;
    border: 3px solid #16a34a;
    border-radius: 8px;
    padding: 10px 22px;
    color: #16a34a;
    font-size: 17px;
    font-weight: 900;
    letter-spacing: 4px;
    text-transform: uppercase;
    transform: rotate(-5deg);
    margin: 6px auto;
    opacity: 0.88;
}
.stamp-offer { border-color: #267BF1; color: #267BF1; }
.stamp-date  { font-size: 9.5px; color: #16a34a; margin-top: 5px; opacity: 0.75; }
.stamp-date-offer { color: #267BF1; }

/* ── Footer ────────────────────────────────────────────────── */
.footer {
    margin-top: 30px;
    padding: 16px 40px;
    background: #f4f7ff;
    border-top: 2px solid rgba(38,123,241,0.14);
}
.footer-inner  { display: table; width: 100%; }
.footer-left   { display: table-cell; vertical-align: middle; }
.footer-right  { display: table-cell; vertical-align: middle; text-align: right; }
.footer-line   { font-size: 9px; color: #8a9bb8; line-height: 1.7; }
.footer-site   { font-size: 11px; color: #267BF1; font-weight: 700; }
.footer-divider { height: 1px; background: rgba(38,123,241,0.09); margin: 5px 0; }
</style>
</head>
<body>

<!-- Watermark -->
<div class="watermark">
    {{ in_array($status, ['signed', 'approved']) ? __('pdf.loan.stamp_signed') : __('pdf.loan.stamp_offer') }}
</div>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <div class="logo-wrap">
            <div class="logo-cell">
                <span class="logo-pdf-kapital">Kapital</span><span class="logo-pdf-sep">|</span><span class="logo-pdf-stark">Stark</span>
                <div class="logo-sub">Financial Services</div>
            </div>
        </div>
    </div>
    <div class="header-right">
        <div class="doc-title">
            {{ $status === 'offer' ? __('pdf.loan.title_offer') : ($status === 'approved' ? __('pdf.loan.title_approved') : __('pdf.loan.title_signed')) }}
        </div>
        <div class="doc-ref">{{ __('pdf.loan.ref') }} : {{ $ref }}</div>
        <div class="doc-date">{{ __('pdf.loan.issued') }} {{ $date }}</div>
    </div>
</div>
<div class="accent-bar"></div>

<!-- Status strip -->
<div class="status-strip status-strip-{{ $status }}">
    <div class="status-dot-cell">
        <span class="status-dot status-dot-{{ $status }}"></span>
    </div>
    <div class="status-text-cell">
        <div class="status-label-{{ $status }}">
            {{ $status === 'offer' ? __('pdf.loan.status_offer') : ($status === 'approved' ? __('pdf.loan.status_approved') : __('pdf.loan.status_signed')) }}
        </div>
    </div>
</div>

<!-- Body -->
<div class="body">

    <!-- 1 · Parties -->
    <div class="section-title">{{ __('pdf.loan.parties') }}</div>
    <div class="info-grid">
        <div class="info-col">
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.lender') }}</div>
                <div class="info-value">KapitalStark Financial Services</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.accreditation') }}</div>
                <div class="info-value-sm">{{ __('pdf.loan.accreditation') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.ref') }}</div>
                <div class="info-value-sm">
                    {{ $status === 'offer' ? __('pdf.loan.doc_type_offer') : __('pdf.loan.doc_type_signed') }}
                </div>
            </div>
        </div>
        <div class="info-col">
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.borrower') }}</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.email') }}</div>
                <div class="info-value-sm">{{ $user->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.client_number') }}</div>
                <div class="info-value-sm">KS-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>

    <!-- 2 · Caractéristiques -->
    <div class="section-title">{{ __('pdf.loan.details') }}</div>

    <div class="highlight-box">
        <div class="highlight-grid">
            <div class="highlight-cell">
                <div class="highlight-label">{{ __('pdf.loan.amount') }}</div>
                <div class="highlight-value">{{ number_format($loan->amount, 0, ',', ' ') }} €</div>
                <div class="highlight-sub">{{ __('pdf.loan.capital') }}</div>
            </div>
            <div class="highlight-cell">
                <div class="highlight-label">{{ __('pdf.loan.monthly') }}</div>
                <div class="highlight-value">{{ number_format($monthly, 2, ',', ' ') }} €</div>
                <div class="highlight-sub">{{ __('pdf.loan.excl_insurance') }}</div>
            </div>
            <div class="highlight-cell">
                <div class="highlight-label">{{ __('pdf.loan.duration') }}</div>
                <div class="highlight-value-sm">{{ $loan->duration_months }} {{ __('pdf.loan.months') }}</div>
                <div class="highlight-sub">{{ round($loan->duration_months / 12, 1) }} {{ __('pdf.loan.years') }}</div>
            </div>
            <div class="highlight-cell">
                <div class="highlight-label">{{ __('pdf.loan.rate') }}</div>
                <div class="highlight-value-sm">{{ $rate }} %</div>
                <div class="highlight-sub">{{ __('pdf.loan.fixed_rate') }}</div>
            </div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.loan_type') }}</div>
                <div class="info-value-sm">
                    {{ trans('loans.data.' . $loan->loan_type . '.title') ?: ucfirst($loan->loan_type) }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.purpose') }}</div>
                <div class="info-value-sm">{{ Str::limit($loan->purpose, 65) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.repayment') }}</div>
                <div class="info-value-sm">{{ __('pdf.loan.fixed_installments') }}</div>
            </div>
        </div>
        <div class="info-col">
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.income') }}</div>
                <div class="info-value-sm">{{ number_format($loan->income, 0, ',', ' ') }} € {{ __('pdf.loan.per_month') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.charges') }}</div>
                <div class="info-value-sm">{{ number_format($loan->charges, 0, ',', ' ') }} € {{ __('pdf.loan.per_month') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">{{ __('pdf.loan.debt_ratio') }}</div>
                <div class="info-value-sm">
                    @php $taux = $loan->income > 0 ? round(($monthly / $loan->income) * 100, 1) : 0; @endphp
                    {{ $taux }} %
                    <span style="font-size:10px;color:{{ $taux <= 33 ? '#16a34a' : '#dc2626' }};font-weight:700;">
                        {{ $taux <= 33 ? __('pdf.loan.compliant') : __('pdf.loan.high') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 · Amortissement -->
    <div class="section-title">{{ __('pdf.loan.schedule') }}</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('pdf.loan.installment_n') }}</th>
                <th>{{ __('pdf.loan.date') }}</th>
                <th>{{ __('pdf.loan.monthly_col') }}</th>
                <th>{{ __('pdf.loan.principal') }}</th>
                <th>{{ __('pdf.loan.interest') }}</th>
                <th>{{ __('pdf.loan.remaining') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedule as $row)
            <tr>
                <td style="font-weight:700;color:#267BF1;">N° {{ $row['n'] }}</td>
                <td>{{ $row['date'] }}</td>
                <td style="font-family:'Courier New',monospace;font-weight:700;color:#1a2540;">{{ $row['monthly'] }} €</td>
                <td>{{ $row['principal'] }} €</td>
                <td style="color:#8a9bb8;">{{ $row['interest'] }} €</td>
                <td>{{ $row['balance'] }} €</td>
            </tr>
            @endforeach
            <tr style="background:rgba(38,123,241,0.03);">
                <td colspan="5" style="color:#8a9bb8;font-style:italic;font-size:10px;padding:10px 12px;">
                    … {{ $loan->duration_months - count($schedule) }} {{ str_replace(':n', $loan->duration_months - count($schedule), __('pdf.loan.remaining_n')) }}
                </td>
                <td style="text-align:right;color:#8a9bb8;">—</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">{{ __('pdf.loan.total') }}</td>
                <td colspan="3"></td>
                <td>{{ number_format($monthly * $loan->duration_months, 2, ',', ' ') }} €</td>
            </tr>
        </tfoot>
    </table>

    <!-- 4 · Conditions -->
    <div class="section-title">{{ __('pdf.loan.conditions') }}</div>
    <div class="conditions-box">
        <div class="condition-item">
            <div class="condition-title">{{ __('pdf.loan.withdrawal_title') }}</div>
            <div class="condition-text">{{ __('pdf.loan.withdrawal_text') }}</div>
        </div>
        <div class="condition-item">
            <div class="condition-title">{{ __('pdf.loan.insurance_title') }}</div>
            <div class="condition-text">{{ __('pdf.loan.insurance_text') }}</div>
        </div>
        <div class="condition-item">
            <div class="condition-title">{{ __('pdf.loan.early_title') }}</div>
            <div class="condition-text">{{ __('pdf.loan.early_text') }}</div>
        </div>
    </div>

    <!-- 5 · Signatures -->
    <div class="section-title">{{ __('pdf.loan.signatures') }}</div>
    <div class="sig-row">
        <div class="sig-cell">
            <div class="sig-box">
                <div style="color:#c4cede;font-size:10px;">{{ __('pdf.loan.sig_borrower') }}</div>
            </div>
            <div class="sig-label">{{ $user->name }}</div>
        </div>
        <div class="sig-cell" style="text-align:center;">
            <div class="stamp-wrap">
                @if($status === 'signed')
                    <div class="stamp">{{ __('pdf.loan.stamp_signed') }}</div>
                    <div class="stamp-date">{{ $date }}</div>
                @else
                    <div class="stamp stamp-offer">{{ __('pdf.loan.stamp_offer') }}</div>
                    <div class="stamp-date stamp-date-offer">{{ __('pdf.loan.stamp_valid') }}</div>
                @endif
            </div>
        </div>
        <div class="sig-cell">
            <div class="sig-box">
                <div style="color:#c4cede;font-size:10px;">{{ __('pdf.loan.sig_institution') }}</div>
            </div>
            <div class="sig-label">KapitalStark · {{ __('pdf.loan.sig_advisor') }}</div>
        </div>
    </div>

</div>{{-- .body --}}

<!-- Footer -->
<div class="footer">
    <div class="footer-inner">
        <div class="footer-left">
            <div class="footer-line"><strong>{{ __('pdf.loan.footer_legal') }}</strong></div>
            <div class="footer-divider"></div>
            <div class="footer-line">{{ __('pdf.loan.footer_confidential') }} · {{ __('pdf.loan.ref') }} {{ $ref }} · {{ $date }}</div>
        </div>
        <div class="footer-right">
            <div class="footer-site">{{ __('pdf.loan.footer_website') }}</div>
            <div class="footer-line" style="margin-top:4px;">{{ __('pdf.loan.page') }}</div>
        </div>
    </div>
</div>

</body>
</html>
