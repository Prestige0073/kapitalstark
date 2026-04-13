{{--
  Composant : accordéon FAQ accessible + Schema FAQPage JSON-LD
  Usage : @include('components.faq-accordion', ['faqs' => $collection, 'pageTitle' => 'FAQ'])
--}}

@php
    $faqs = $faqs ?? collect();
    if (is_array($faqs)) $faqs = collect($faqs);
    $pageTitle = $pageTitle ?? 'Questions fréquentes';
@endphp

@if($faqs->isNotEmpty())
<!-- Schema FAQPage JSON-LD -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    {
      "@@type": "Question",
      "name": {{ json_encode(is_array($faq) ? $faq['question'] : $faq->question, JSON_UNESCAPED_UNICODE) }},
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": {{ json_encode(strip_tags(is_array($faq) ? $faq['answer'] : $faq->answer), JSON_UNESCAPED_UNICODE) }}
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>

<div class="faq-accordion" aria-label="{{ $pageTitle }}">
    @foreach($faqs as $faq)
    @php
        $q = is_array($faq) ? $faq['question'] : $faq->question;
        $a = is_array($faq) ? $faq['answer'] : $faq->answer;
        $idx = $loop->index;
    @endphp
    <details class="faq-accordion__item" @if($idx === 0) open @endif>
        <summary class="faq-accordion__question" aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}">
            <span>{{ $q }}</span>
            <svg class="faq-accordion__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </summary>
        <div class="faq-accordion__answer">
            <div class="faq-accordion__answer-inner">{!! nl2br(e($a)) !!}</div>
        </div>
    </details>
    @endforeach
</div>
@endif
