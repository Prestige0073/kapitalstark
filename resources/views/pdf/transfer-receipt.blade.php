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
    color: rgba(16,163,74,0.04);
    letter-spacing: 14px;
    text-transform: uppercase;
    white-space: nowrap;
    z-index: 0;
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

.logo-wrap         { display: table; }
.logo-cell         { display: table-cell; vertical-align: middle; }
.logo-pdf-kapital  { font-family: Georgia, serif; font-style: italic; font-weight: bold; font-size: 22px; color: #fff; letter-spacing: -0.3px; }
.logo-pdf-sep      { font-family: Georgia, serif; font-size: 18px; color: #C8A951; padding: 0 6px; font-style: normal; }
.logo-pdf-stark    { font-family: 'Courier New', Courier, monospace; font-weight: bold; font-size: 13px; color: #A8CFF7; text-transform: uppercase; letter-spacing: 2.5px; }
.logo-sub          { color: rgba(255,255,255,0.4); font-size: 9.5px; letter-spacing: 2px; text-transform: uppercase; margin-top: 3px; }

.doc-type  { color: #4ade80; font-size: 13px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
.doc-ref   { color: rgba(255,255,255,0.5); font-size: 10px; margin-top: 5px; letter-spacing: 0.5px; }
.doc-gen   { color: rgba(255,255,255,0.4); font-size: 9.5px; margin-top: 3px; }

/* ── Accent bar ────────────────────────────────────────────── */
.accent-bar { height: 5px; background: linear-gradient(90deg, #16a34a 0%, #267BF1 55%, #0a1628 100%); }

/* ── Status strip ──────────────────────────────────────────── */
.status-strip {
    background: rgba(22,163,74,0.07);
    border-bottom: 1px solid rgba(22,163,74,0.2);
    padding: 12px 40px;
    display: table;
    width: 100%;
}
.status-icon-cell { display: table-cell; vertical-align: middle; width: 30px; }
.status-icon {
    width: 24px; height: 24px;
    background: #16a34a;
    border-radius: 50%;
    text-align: center;
    padding-top: 5px;
}
.status-text-cell { display: table-cell; vertical-align: middle; padding-left: 12px; }
.status-label { font-size: 11.5px; font-weight: 700; color: #15803d; }
.status-sub   { font-size: 10px; color: #4ade80; margin-top: 2px; }
.status-date  { display: table-cell; vertical-align: middle; text-align: right; font-size: 10px; color: #8a9bb8; }

/* ── Body ──────────────────────────────────────────────────── */
.body { padding: 30px 40px 0; position: relative; z-index: 1; }

/* ── Amount hero ───────────────────────────────────────────── */
.amount-hero {
    text-align: center;
    padding: 30px 0 26px;
    border-bottom: 1.5px solid rgba(38,123,241,0.09);
    margin-bottom: 30px;
}
.amount-direction {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.amount-direction--credit { color: #16a34a; }
.amount-direction--debit  { color: #dc2626; }

.amount-value {
    font-family: 'Courier New', monospace;
    font-weight: 900;
    font-size: 48px;
    line-height: 1;
}
.amount-value--credit { color: #16a34a; }
.amount-value--debit  { color: #dc2626; }

.amount-label { font-size: 10px; color: #8a9bb8; margin-top: 10px; letter-spacing: 0.5px; }

/* ── Section title ─────────────────────────────────────────── */
.section-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #267BF1;
    border-bottom: 1.5px solid rgba(38,123,241,0.15);
    padding-bottom: 6px;
    margin-bottom: 16px;
    margin-top: 26px;
}
.section-title:first-child { margin-top: 0; }

/* ── Detail table ──────────────────────────────────────────── */
.detail-table { width: 100%; border-collapse: collapse; }
.detail-table tr { border-bottom: 1px solid rgba(38,123,241,0.06); }
.detail-table tr:last-child { border-bottom: none; }
.detail-table td { padding: 11px 6px; vertical-align: middle; }
.detail-label {
    color: #8a9bb8;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.9px;
    width: 42%;
}
.detail-value      { color: #1a2540; font-size: 12px; font-weight: 600; }
.detail-value--mono { font-family: 'Courier New', monospace; font-size: 12px; font-weight: 600; }
.detail-value--ref  {
    color: #267BF1;
    font-family: 'Courier New', monospace;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* ── Info box ──────────────────────────────────────────────── */
.info-box {
    background: #f4f7ff;
    border: 1px solid rgba(38,123,241,0.12);
    border-left: 5px solid #267BF1;
    border-radius: 8px;
    padding: 16px 20px;
    margin-top: 26px;
}
.info-box-title { font-size: 11px; font-weight: 700; color: #1a2540; margin-bottom: 5px; }
.info-box-text  { font-size: 11px; color: #5a6a8a; line-height: 1.65; }

/* ── Verify row ────────────────────────────────────────────── */
.verify-row { display: table; width: 100%; margin-top: 26px; }
.verify-text-cell { display: table-cell; vertical-align: middle; padding-right: 24px; }
.verify-qr-cell   { display: table-cell; vertical-align: middle; text-align: right; width: 90px; }

.verify-title { font-size: 12px; font-weight: 700; color: #1a2540; margin-bottom: 8px; }
.verify-text  { font-size: 11px; color: #5a6a8a; line-height: 1.65; }
.verify-ref   { color: #267BF1; font-weight: 700; }

/* ── QR code ───────────────────────────────────────────────── */
.qr-wrap { text-align: center; }
.qr-wrap svg {
    width: 82px;
    height: 82px;
    display: block;
    padding: 4px;
    background: #fff;
    border: 2px solid rgba(38,123,241,0.22);
    border-radius: 8px;
}
.qr-label { font-size: 8.5px; color: #8a9bb8; margin-top: 5px; text-align: center; letter-spacing: 0.5px; }

/* ── Footer ────────────────────────────────────────────────── */
.footer {
    margin-top: 30px;
    padding: 16px 40px;
    background: #f4f7ff;
    border-top: 2px solid rgba(38,123,241,0.14);
}
.footer-inner { display: table; width: 100%; }
.footer-left  { display: table-cell; vertical-align: middle; }
.footer-right { display: table-cell; vertical-align: middle; text-align: right; }
.footer-line  { font-size: 9px; color: #8a9bb8; line-height: 1.7; }
.footer-site  { font-size: 11px; color: #267BF1; font-weight: 700; }
.footer-divider { height: 1px; background: rgba(38,123,241,0.09); margin: 5px 0; }
</style>
</head>
<body>

<div class="watermark">VALIDÉ</div>

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
        <div class="doc-type">
            {{ $credit ? __('pdf.receipt.title_credit') : __('pdf.receipt.title_debit') }}
        </div>
        <div class="doc-ref">{{ __('pdf.receipt.ref') }} : {{ $ref }}</div>
        <div class="doc-gen">{{ __('pdf.receipt.generated') }} {{ $generated }}</div>
    </div>
</div>
<div class="accent-bar"></div>

<!-- Status strip -->
<div class="status-strip">
    <div class="status-icon-cell">
        <div class="status-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>
    </div>
    <div class="status-text-cell">
        <div class="status-label">{{ __('pdf.receipt.success') }}</div>
        <div class="status-sub">{{ __('pdf.receipt.processed') }}</div>
    </div>
    <div class="status-date">{{ $date }}</div>
</div>

<!-- Body -->
<div class="body">

    <!-- Amount hero -->
    <div class="amount-hero">
        <div class="amount-direction amount-direction--{{ $credit ? 'credit' : 'debit' }}">
            {{ $credit ? __('pdf.receipt.amount_received') : __('pdf.receipt.amount_debited') }}
        </div>
        <div class="amount-value amount-value--{{ $credit ? 'credit' : 'debit' }}">
            {{ $credit ? '+' : '-' }}{{ ltrim(str_replace(['+', '-'], '', $amount)) }}
        </div>
        <div class="amount-label">{{ __('pdf.receipt.amount_note') }}</div>
    </div>

    <!-- Transaction details -->
    <div class="section-title">{{ __('pdf.receipt.details') }}</div>
    <table class="detail-table">
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.reference') }}</td>
            <td class="detail-value detail-value--ref">{{ $ref }}</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.label') }}</td>
            <td class="detail-value">{{ $label }}</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.op_date') }}</td>
            <td class="detail-value">{{ $date }}</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.op_type') }}</td>
            <td class="detail-value">
                {{ $credit ? __('pdf.receipt.incoming') : __('pdf.receipt.outgoing') }}
            </td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.card_used') }}</td>
            <td class="detail-value detail-value--mono">•••• •••• •••• {{ $card_last4 }}</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.status') }}</td>
            <td class="detail-value" style="color:#16a34a;font-weight:700;">
                {{ __('pdf.receipt.completed') }}
            </td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.fees') }}</td>
            <td class="detail-value">
                0,00 €
                <span style="color:#16a34a;font-size:10.5px;font-weight:700;">
                    ({{ __('pdf.receipt.fees_free') }})
                </span>
            </td>
        </tr>
    </table>

    <!-- Account info -->
    <div class="section-title">{{ __('pdf.receipt.account') }}</div>
    <table class="detail-table">
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.holder') }}</td>
            <td class="detail-value">{{ $user->name }}</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.client_number') }}</td>
            <td class="detail-value detail-value--mono">KS-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.institution') }}</td>
            <td class="detail-value">KapitalStark Financial Services</td>
        </tr>
        <tr>
            <td class="detail-label">{{ __('pdf.receipt.iban') }}</td>
            <td class="detail-value detail-value--mono">
                FR•• •••• •••• •••• •••• •••• {{ str_pad($user->id % 100, 3, '0', STR_PAD_LEFT) }}
            </td>
        </tr>
    </table>

    <!-- Verify + QR -->
    <div class="verify-row">
        <div class="verify-text-cell">
            <div class="verify-title">{{ __('pdf.receipt.verify_title') }}</div>
            <div class="verify-text">
                {{ __('pdf.receipt.verify_text') }}
                <br>
                <span style="margin-top:4px;display:block;">
                    {{ __('pdf.receipt.ref') }} : <span class="verify-ref">{{ $ref }}</span>
                </span>
            </div>
        </div>
        <div class="verify-qr-cell">
            <div class="qr-wrap">
                {!! $qrSvg !!}
                <div class="qr-label">kapitalstark.fr</div>
            </div>
        </div>
    </div>

    <!-- Conservation box -->
    <div class="info-box">
        <div class="info-box-title">{{ __('pdf.receipt.conservation') }}</div>
        <div class="info-box-text">{{ __('pdf.receipt.conservation_text') }}</div>
    </div>

</div>

<!-- Footer -->
<div class="footer">
    <div class="footer-inner">
        <div class="footer-left">
            <div class="footer-line"><strong>{{ __('pdf.receipt.footer_legal') }}</strong></div>
            <div class="footer-divider"></div>
            <div class="footer-line">{{ __('pdf.receipt.footer_confidential') }} · {{ $generated }}</div>
        </div>
        <div class="footer-right">
            <div class="footer-site">{{ __('pdf.receipt.footer_website') }}</div>
        </div>
    </div>
</div>

</body>
</html>
