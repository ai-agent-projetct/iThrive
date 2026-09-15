<?php
/**
 * Matching the visitor's question to the answer book, in six languages.
 *
 * The naive approach — storing every question translated into every language —
 * needs 350 fixed strings and still only fires when the visitor phrases things
 * the way we guessed. People do not. So instead the vocabulary of each language
 * is mapped onto the English terms the answer book already indexes: a Tamil,
 * Malayalam, Kannada, Telugu or Hindi question is normalised into English
 * concepts, then scored against all seventy entries the same way an English one
 * is. Paraphrases match; so do mixed-script questions, which is how people
 * actually type on Indian keyboards.
 *
 * Everything outside the answer book gets FAQ_DEMO_REPLY — the demo boundary,
 * with an offer to bring in a human. That refusal is the point of the demo, so
 * it is written properly in all six languages rather than machine-shaped.
 */

declare(strict_types=1);

require_once __DIR__ . '/faq.php';

/**
 * Indic vocabulary → the English terms the answer book is indexed on.
 *
 * Matched as substrings against the raw question, because these languages
 * agglutinate: "விலை" is inside "விலையை", "விலையென்ன" and so on, and splitting
 * on whitespace would miss every inflected form.
 */
const FAQ_LEXICON = [
    // cost / price
    'விலை' => 'cost price', 'செலவு' => 'cost price', 'கட்டணம்' => 'cost price',
    'பணம்' => 'cost price money',
    'വില' => 'cost price', 'ചെലവ' => 'cost price',
    'ಬೆಲೆ' => 'cost price', 'ವೆಚ್ಚ' => 'cost price',
    'ధర' => 'cost price', 'ఖర్చు' => 'cost price',
    'कीमत' => 'cost price', 'लागत' => 'cost price', 'खर्च' => 'cost price', 'शुल्क' => 'cost price',

    // Bare quantity words. These do NOT imply cost — "how much time" is a
    // timeline question, and mapping them to price sent it to the wrong answer.
    'எவ்வளவு' => 'quantity', 'എത്ര' => 'quantity', 'ಎಷ್ಟು' => 'quantity',
    'ఎంత' => 'quantity', 'कितना' => 'quantity', 'कितने' => 'quantity',

    // time / duration
    'நேரம்' => 'timeline how long', 'காலம்' => 'timeline how long', 'வாரம்' => 'timeline weeks',
    'நாட்கள்' => 'timeline days', 'எப்போது' => 'timeline when',
    'സമയ' => 'timeline how long', 'ആഴ്ച' => 'timeline weeks', 'എപ്പോൾ' => 'timeline when',
    'ಸಮಯ' => 'timeline how long', 'ವಾರ' => 'timeline weeks', 'ಯಾವಾಗ' => 'timeline when',
    'సమయ' => 'timeline how long', 'వారం' => 'timeline weeks', 'ఎప్పుడు' => 'timeline when',
    'समय' => 'timeline how long', 'सप्ताह' => 'timeline weeks', 'कब' => 'timeline when',
    'अवधि' => 'timeline duration',

    // build / develop / make
    'உருவாக்க' => 'build develop', 'கட்டமைக்க' => 'build develop', 'செய்ய' => 'build do',
    'நிர்மാ' => 'build develop', 'നിർമ്മി' => 'build develop', 'ഉണ്ടാക്ക' => 'build develop',
    'ನಿರ್ಮಿ' => 'build develop', 'ಮಾಡ' => 'build do', 'ರಚಿ' => 'build develop',
    'నిర్మి' => 'build develop', 'తయారు' => 'build develop', 'చేస్' => 'build do',
    'बनाते' => 'build develop', 'बनाना' => 'build develop', 'विकास' => 'build develop',
    'निर्माण' => 'build develop',

    // AI / machine learning
    'செயற்கை நுண்ணறிவு' => 'ai artificial intelligence', 'ஏஐ' => 'ai',
    'நுண்ணறிவு' => 'ai intelligence', 'இயந்திர கற்றல்' => 'machine learning ai',
    'നിർമ്മിത ബുദ്ധി' => 'ai artificial intelligence', 'എഐ' => 'ai',
    'ಕೃತಕ ಬುದ್ಧಿ' => 'ai artificial intelligence', 'ಎಐ' => 'ai',
    'కృత్రిమ మేధ' => 'ai artificial intelligence', 'ఏఐ' => 'ai',
    'कृत्रिम बुद्धि' => 'ai artificial intelligence', 'एआई' => 'ai',

    // assistant / chatbot / agent. Both the native word and the transliterated
    // English one, because people type "അസിസ്റ്റന്റ്" as readily as "സഹായി".
    'உதவியாளர்' => 'assistant chatbot', 'அரட்டை' => 'chatbot chat', 'முகவர்' => 'agent assistant',
    'அசிஸ்டன்ட்' => 'assistant chatbot', 'சாட்பாட்' => 'chatbot chat',
    'സഹായി' => 'assistant chatbot', 'ചാറ്റ്' => 'chatbot chat',
    'അസിസ്റ്റന്റ്' => 'assistant chatbot', 'ചാറ്റ്ബോട്ട്' => 'chatbot chat',
    'ಸಹಾಯಕ' => 'assistant chatbot', 'ಚಾಟ್' => 'chatbot chat', 'ಅಸಿಸ್ಟೆಂಟ್' => 'assistant chatbot',
    'సహాయ' => 'assistant chatbot', 'చాట్' => 'chatbot chat', 'అసిస్టెంట్' => 'assistant chatbot',
    'सहायक' => 'assistant chatbot', 'चैट' => 'chatbot chat', 'एजेंट' => 'agent assistant',
    'असिस्टेंट' => 'assistant chatbot', 'चैटबॉट' => 'chatbot chat',

    // services / offering
    'சேவை' => 'services offer', 'സേവന' => 'services offer', 'ಸೇವೆ' => 'services offer',
    'సేవ' => 'services offer', 'सेवा' => 'services offer', 'सेवाएं' => 'services offer',

    // project / product
    'திட்டம்' => 'project', 'ப்ராஜெக்ட்' => 'project', 'தயாரிப்பு' => 'product',
    'പ്രോജക്ട്' => 'project', 'ഉൽപ്പന്ന' => 'product',
    'ಯೋಜನೆ' => 'project', 'ಪ್ರಾಜೆಕ್ಟ್' => 'project', 'ಉತ್ಪನ್ನ' => 'product',
    'ప్రాజెక్ట్' => 'project', 'ప్రాజెక్టు' => 'project', 'ఉత్పత్తి' => 'product',
    'प्रोजेक्ट' => 'project', 'परियोजना' => 'project', 'उत्पाद' => 'product',

    // mobile / app
    'மொபைல்' => 'mobile app', 'செயலி' => 'app mobile', 'கைபேசி' => 'mobile app',
    'മൊബൈൽ' => 'mobile app', 'ആപ്പ്' => 'app mobile',
    'ಮೊಬೈಲ್' => 'mobile app', 'ಆಪ್' => 'app mobile',
    'మొబైల్' => 'mobile app', 'యాప్' => 'app mobile',
    'मोबाइल' => 'mobile app', 'ऐप' => 'app mobile', 'एप्लिकेशन' => 'app application',

    // web / website
    'இணையதள' => 'web website', 'வலைத்தள' => 'web website',
    'വെബ്' => 'web website', 'വെബ്‌സൈറ്റ്' => 'web website',
    'ವೆಬ್' => 'web website', 'ಜಾಲತಾಣ' => 'web website',
    'వెబ్' => 'web website', 'వెబ్‌సైట్' => 'web website',
    'वेब' => 'web website', 'वेबसाइट' => 'web website',

    // e-commerce / shop
    'இணையவணிக' => 'ecommerce shop store', 'கடை' => 'ecommerce shop store',
    'விற்பனை' => 'sales ecommerce', 'வணிக' => 'business ecommerce',
    'കട' => 'ecommerce shop store', 'വിൽപ്പന' => 'sales ecommerce',
    'ಅಂಗಡಿ' => 'ecommerce shop store', 'ಮಾರಾಟ' => 'sales ecommerce',
    'దుకాణ' => 'ecommerce shop store', 'అమ్మక' => 'sales ecommerce',
    'दुकान' => 'ecommerce shop store', 'बिक्री' => 'sales ecommerce', 'ईकॉमर्स' => 'ecommerce',

    // team / hiring
    'குழு' => 'team dedicated', 'பணியமர்த்த' => 'hire team', 'ஊழியர்' => 'team staff',
    'ടീം' => 'team dedicated', 'നിയമി' => 'hire team',
    'ತಂಡ' => 'team dedicated', 'ನೇಮಕ' => 'hire team',
    'బృంద' => 'team dedicated', 'నియామక' => 'hire team',
    'टीम' => 'team dedicated', 'नियुक्त' => 'hire team', 'भर्ती' => 'hire team',

    // security / data / IP
    'பாதுகாப்பு' => 'security protect', 'தரவு' => 'data', 'உரிமை' => 'ip ownership rights',
    'ரகசிய' => 'confidential privacy',
    'സുരക്ഷ' => 'security protect', 'ഡാറ്റ' => 'data', 'അവകാശ' => 'ip ownership rights',
    'ಭದ್ರತೆ' => 'security protect', 'ಡೇಟಾ' => 'data', 'ಹಕ್ಕು' => 'ip ownership rights',
    'భద్రత' => 'security protect', 'డేటా' => 'data', 'హక్కు' => 'ip ownership rights',
    'सुरक्षा' => 'security protect', 'डेटा' => 'data', 'अधिकार' => 'ip ownership rights',
    'गोपनीय' => 'confidential privacy',

    // Source code and ownership, as people actually write it.
    //
    // The formal words above are the ones a dictionary gives; they are not what
    // gets typed. Indic speakers write English technical nouns in their own
    // script, so "who owns the source code" arrives as சோர்ஸ் கோட் or सोर्स कोड
    // and matched nothing at all — while the same question in English is one of
    // the most asked on the site. Ownership was the gap: "app" and "cost" were
    // already transliterated here, which is why pricing questions worked in all
    // five languages and this one worked in none.
    'கோட்' => 'code source', 'சோர்ஸ்' => 'source code', 'சொந்த' => 'ownership own belong',
    'കോഡ്' => 'code source', 'സോഴ്സ്' => 'source code', 'സ്വന്ത' => 'ownership own belong',
    'ಕೋಡ್' => 'code source', 'ಸೋರ್ಸ್' => 'source code', 'ಸ್ವಂತ' => 'ownership own belong',
    'కోడ్' => 'code source', 'సోర్స్' => 'source code', 'సొంత' => 'ownership own belong',
    'कोड' => 'code source', 'सोर्स' => 'source code', 'मालिक' => 'ownership own belong',
    'स्वामित्व' => 'ownership own belong',

    // cloud / devops / server
    'கிளவுட்' => 'cloud', 'மேகக்கணினி' => 'cloud', 'சேவையக' => 'server cloud',
    'ക്ലൗഡ്' => 'cloud', 'സെർവർ' => 'server cloud',
    'ಕ್ಲೌಡ್' => 'cloud', 'ಸರ್ವರ್' => 'server cloud',
    'క్లౌడ్' => 'cloud', 'సర్వర్' => 'server cloud',
    'क्लाउड' => 'cloud', 'सर्वर' => 'server cloud',

    // support / maintenance
    'பராமரிப்பு' => 'maintenance support', 'ஆதரவு' => 'support',
    'പരിപാലന' => 'maintenance support', 'പിന്തുണ' => 'support',
    'ನಿರ್ವಹಣೆ' => 'maintenance support', 'ಬೆಂಬಲ' => 'support',
    'నిర్వహణ' => 'maintenance support', 'మద్దతు' => 'support',
    'रखरखाव' => 'maintenance support', 'सहायता' => 'support', 'सपोर्ट' => 'support',

    // start / process
    'தொடங்க' => 'start begin process', 'ஆரம்பி' => 'start begin',
    'செயல்முறை' => 'process steps', 'படிகள்' => 'steps process',
    'തുടങ്ങ' => 'start begin process', 'പ്രക്രിയ' => 'process steps',
    'ಪ್ರಾರಂಭ' => 'start begin', 'ಪ್ರಕ್ರಿಯೆ' => 'process steps',
    'ప్రారంభ' => 'start begin', 'ప్రక్రియ' => 'process steps',
    'शुरू' => 'start begin', 'प्रक्रिया' => 'process steps', 'चरण' => 'steps process',

    // difference / compare
    'வித்தியாசம்' => 'difference compare', 'வேறுபாடு' => 'difference compare',
    'വ്യത്യാസ' => 'difference compare', 'ವ್ಯತ್ಯಾಸ' => 'difference compare',
    'తేడా' => 'difference compare', 'अंतर' => 'difference compare', 'फर्क' => 'difference compare',

    // benefit / ROI
    'பயன்' => 'benefit roi', 'லாபம்' => 'profit roi revenue', 'வருவாய்' => 'revenue growth',
    'പ്രയോജന' => 'benefit roi', 'ലാഭ' => 'profit roi revenue',
    'ಪ್ರಯೋಜನ' => 'benefit roi', 'ಲಾಭ' => 'profit roi revenue',
    'ప్రయోజన' => 'benefit roi', 'లాభ' => 'profit roi revenue',
    'लाभ' => 'benefit roi', 'फायदा' => 'benefit roi', 'राजस्व' => 'revenue growth',

    // payment
    'பணம் செலுத்த' => 'payment gateway', 'கொடுப்பனவு' => 'payment gateway',
    'പേയ്‌മെന്റ്' => 'payment gateway', 'ಪಾವತಿ' => 'payment gateway',
    'చెల్లింపు' => 'payment gateway', 'भुगतान' => 'payment gateway',

    // ERP / legacy / modernisation
    'பழைய' => 'legacy old modernization', 'நவீனமாக்க' => 'modernization upgrade',
    'പഴയ' => 'legacy old modernization', 'ಹಳೆಯ' => 'legacy old modernization',
    'పాత' => 'legacy old modernization', 'पुराना' => 'legacy old modernization',
    'आधुनिक' => 'modernization upgrade',
    // vision / OCR — the AI Development Company page's own subject matter, and
    // a topic the answer book gained entries for (q79) with no way for a
    // non-English question to reach them.
    'பார்வை' => 'vision computer vision', 'படம்' => 'image vision', 'புகைப்பட' => 'image photo vision',
    'ஸ்கேன்' => 'scan ocr', 'ஆவணம்' => 'document ocr',
    'ദൃശ്യ' => 'vision computer vision', 'ചിത്ര' => 'image vision', 'സ്കാൻ' => 'scan ocr',
    'ರೇಖಾ' => 'image vision', 'ದೃಷ್ಟಿ' => 'vision computer vision', 'ಚಿತ್ರ' => 'image vision',
    'ದಾಖಲೆ' => 'document ocr',
    'దృష్టి' => 'vision computer vision', 'చిత్ర' => 'image vision', 'పత్ర' => 'document ocr',
    'दृष्टि' => 'vision computer vision', 'छवि' => 'image vision', 'चित्र' => 'image vision',
    'दस्तावेज' => 'document ocr', 'स्कैन' => 'scan ocr',

    // voice / speech — the assistant itself is the worked example (q80)
    'குரல்' => 'voice speech voicebot', 'பேச' => 'speech talk voice',
    'ശബ്ദ' => 'voice speech voicebot', 'സംസാരി' => 'speech talk voice',
    'ಧ್ವನಿ' => 'voice speech voicebot', 'ಮಾತನಾಡ' => 'speech talk voice',
    'వాయిస్' => 'voice speech voicebot', 'మాట్లాడ' => 'speech talk voice',
    'आवाज' => 'voice speech voicebot', 'बोल' => 'speech talk voice', 'वॉइस' => 'voice voicebot',

    // where we are — the city questions the AI Development Company page ranks
    // for, so they have to work in the languages those cities actually speak
    'சென்னை' => 'chennai city location', 'பெங்களூரு' => 'bangalore city location',
    'கோயம்புத்தூர்' => 'coimbatore city location', 'இடம்' => 'location where office',
    'ചെന്നൈ' => 'chennai city location', 'ബെംഗളൂരു' => 'bangalore city location',
    'ಬೆಂಗಳೂರು' => 'bangalore city location', 'ಚೆನ್ನೈ' => 'chennai city location',
    'హైదరాబాద్' => 'hyderabad city location', 'చెన్నై' => 'chennai city location',
    'चेन्नई' => 'chennai city location', 'बैंगलोर' => 'bangalore city location',
    'हैदराबाद' => 'hyderabad city location', 'कोयंबटूर' => 'coimbatore city location',
    'कहाँ' => 'where location', 'कार्यालय' => 'office location',

    // compliance, by name — GDPR/HIPAA/ISO travel untranslated, but the words
    // around them do not
    'இணக்க' => 'compliance governance', 'தணிக்கை' => 'audit compliance',
    'അനുസരണ' => 'compliance governance', 'ಅನುಸರಣೆ' => 'compliance governance',
    'సమ్మతి' => 'compliance governance', 'अनुपालन' => 'compliance governance',
    'नियम' => 'compliance rules governance',
    // search / ranking — the web pages' own FAQs turn on this and the brain had
    // no word for it in any script
    'தேடுபொறி' => 'seo search ranking google', 'தரவரிசை' => 'ranking seo',
    'கூகிள்' => 'google search seo',
    'തിരയൽ' => 'seo search ranking google', 'റാങ്ക്' => 'ranking seo',
    'ಹುಡುಕಾಟ' => 'seo search ranking google', 'ಶ್ರೇಣಿ' => 'ranking seo',
    'శోధన' => 'seo search ranking google', 'ర్యాంక్' => 'ranking seo',
    'खोज' => 'seo search ranking google', 'रैंक' => 'ranking seo',
    'गूगल' => 'google search seo', 'सर्च' => 'search seo',

    // design / redesign / rebuild
    'வடிவமைப்பு' => 'design redesign ui', 'மறுவடிவமைப்பு' => 'redesign rebuild',
    'ഡിസൈൻ' => 'design redesign ui', 'ವಿನ್ಯಾಸ' => 'design redesign ui',
    'డిజైన్' => 'design redesign ui', 'डिज़ाइन' => 'design redesign ui',
    'डिजाइन' => 'design redesign ui', 'नया रूप' => 'redesign rebuild',

    // hosting / domain / migration — the handover questions
    'டொமைன்' => 'domain hosting', 'ஹோஸ்டிங்' => 'hosting server domain',
    'இடம்பெயர்' => 'migrate migration move',
    'ഡൊമെയ്ൻ' => 'domain hosting', 'ಡೊಮೇನ್' => 'domain hosting',
    'డొమైన్' => 'domain hosting', 'डोमेन' => 'domain hosting',
    'होस्टिंग' => 'hosting server domain', 'माइग्रेट' => 'migrate migration move',

    // the app stores
    'ஆப் ஸ்டோர்' => 'app store submission play store', 'பிளே ஸ்டோர்' => 'play store app store',
    'ആപ്പ് സ്റ്റോർ' => 'app store submission play store',
    'ಪ್ಲೇ ಸ್ಟೋರ್' => 'play store app store',
    'ప్లే స్టోర్' => 'play store app store',
    'ऐप स्टोर' => 'app store submission play store', 'प्ले स्टोर' => 'play store app store',

    // flutter / cross-platform, written in each script as people actually type it
    'ஃப்ளட்டர்' => 'flutter cross platform dart',
    'ഫ്ലട്ടർ' => 'flutter cross platform dart',
    'ಫ್ಲಟರ್' => 'flutter cross platform dart',
    'ఫ్లట్టర్' => 'flutter cross platform dart',
    'फ्लटर' => 'flutter cross platform dart', 'फ़्लटर' => 'flutter cross platform dart',
    /* ------------------------------------------------------------------
       Vocabulary for the sixteen AI service pages.

       The entries above cover general business language -- cost, timeline,
       hiring, cities. The answers published on the service pages are about
       retrieval, orchestration, automation, fine-tuning, accuracy and
       observability, and none of those had any Indic word pointing at them,
       so an Indian-language question on those subjects scored nothing and
       fell through to the demo boundary.

       Stems rather than whole words, for the same reason as above: these
       languages agglutinate, and the match is a substring test.
       ------------------------------------------------------------------ */

    // automation automate process
    'தானியங்கி' => 'automation automate process', 'தன்னியக்க' => 'automation automate process',
    'ഓട്ടോമേഷൻ' => 'automation automate process',
    'സ്വയംപ്രവർത്തന' => 'automation automate process',
    'ಸ್ವಯಂಚಾಲಿತ' => 'automation automate process', 'ಯಾಂತ್ರೀಕರಣ' => 'automation automate process',
    'ఆటోమేషన్' => 'automation automate process', 'స్వయంచాలక' => 'automation automate process',
    'स्वचालन' => 'automation automate process', 'ऑटोमेशन' => 'automation automate process',

    // integration integrate connect
    'ஒருங்கிணைப்பு' => 'integration integrate connect',
    'இணைப்பு' => 'integration integrate connect', 'സംയോജനം' => 'integration integrate connect',
    'ബന്ധിപ്പിക്ക' => 'integration integrate connect', 'ಏಕೀಕರಣ' => 'integration integrate connect',
    'ಸಂಯೋಜನೆ' => 'integration integrate connect', 'ఏకీకరణ' => 'integration integrate connect',
    'అనుసంధానం' => 'integration integrate connect', 'एकीकरण' => 'integration integrate connect',
    'जोड़ना' => 'integration integrate connect',

    // training finetune model
    'பயிற்சி' => 'training finetune model', 'പരിശീലനം' => 'training finetune model',
    'ತರಬೇತಿ' => 'training finetune model', 'శిక్షణ' => 'training finetune model',
    'प्रशिक्षण' => 'training finetune model',

    // accuracy accurate correct
    'துல்லிய' => 'accuracy accurate correct', 'കൃത്യത' => 'accuracy accurate correct',
    'ನಿಖರತೆ' => 'accuracy accurate correct', 'ఖచ్చితత్వం' => 'accuracy accurate correct',
    'सटीकता' => 'accuracy accurate correct',

    // monitoring observability support
    'கண்காணிப்பு' => 'monitoring observability support',
    'നിരീക്ഷണം' => 'monitoring observability support',
    'ಮೇಲ್ವಿಚಾರಣೆ' => 'monitoring observability support',
    'పర్యవేక్షణ' => 'monitoring observability support',
    'निगरानी' => 'monitoring observability support',

    // speed fast latency
    'வேகம்' => 'speed fast latency', 'വേഗത' => 'speed fast latency', 'ವೇಗ' => 'speed fast latency',
    'వేగం' => 'speed fast latency', 'गति' => 'speed fast latency',

    // error mistake wrong hallucination
    'பிழை' => 'error mistake wrong hallucination', 'தவறு' => 'error mistake wrong hallucination',
    'പിശക' => 'error mistake wrong hallucination', 'ದೋಷ' => 'error mistake wrong hallucination',
    'లోపం' => 'error mistake wrong hallucination', 'తప్పు' => 'error mistake wrong hallucination',
    'त्रुटि' => 'error mistake wrong hallucination', 'गलती' => 'error mistake wrong hallucination',

    // language multilingual
    'மொழி' => 'language multilingual', 'ഭാഷ' => 'language multilingual',
    'ಭಾಷೆ' => 'language multilingual', 'భాష' => 'language multilingual',
    'भाषा' => 'language multilingual',

    // test testing quality
    'சோதனை' => 'test testing quality', 'പരിശോധന' => 'test testing quality',
    'ಪರೀಕ್ಷೆ' => 'test testing quality', 'పరీక్ష' => 'test testing quality',
    'परीक्षण' => 'test testing quality', 'जांच' => 'test testing quality',

    // document retrieval search rag knowledge
    'ஆவண' => 'document retrieval search rag knowledge',
    'அறிவு' => 'document retrieval search rag knowledge',
    'രേഖ' => 'document retrieval search rag knowledge',
    'അറിവ' => 'document retrieval search rag knowledge',
    'ಜ್ಞಾನ' => 'document retrieval search rag knowledge',
    'పత్రం' => 'document retrieval search rag knowledge',
    'జ్ఞానం' => 'document retrieval search rag knowledge',
    'ज्ञान' => 'document retrieval search rag knowledge',

    // deploy deployment launch
    'வெளியீடு' => 'deploy deployment launch', 'വിന്യാസം' => 'deploy deployment launch',
    'ನಿಯೋಜನೆ' => 'deploy deployment launch', 'విస్తరణ' => 'deploy deployment launch',
    'तैनाती' => 'deploy deployment launch',

    // workflow process steps
    'பணிப்பாய்வு' => 'workflow process steps', 'പ്രവർത്തനക്രമം' => 'workflow process steps',
    'ಕಾರ್ಯಹರಿವು' => 'workflow process steps', 'కార్యప్రవాహం' => 'workflow process steps',
    'कार्यप्रवाह' => 'workflow process steps',

    // robotic rpa bot automation
    'ரோபோ' => 'robotic rpa bot automation', 'റോബോട്ട' => 'robotic rpa bot automation',
    'ರೋಬೋ' => 'robotic rpa bot automation', 'రోబో' => 'robotic rpa bot automation',
    'रोबोट' => 'robotic rpa bot automation',

    // safety guardrail control risk
    'பாதுகாப்பான' => 'safety guardrail control risk',
    'கட்டுப்பாடு' => 'safety guardrail control risk',
    'നിയന്ത്രണം' => 'safety guardrail control risk', 'ನಿಯಂತ್ರಣ' => 'safety guardrail control risk',
    'నియంత్రణ' => 'safety guardrail control risk', 'नियंत्रण' => 'safety guardrail control risk',

];

/** Tokens too common to carry meaning. */
const FAQ_STOPWORDS = [
    'the','a','an','is','are','was','were','be','been','do','does','did','of','to','in','on','for',
    'and','or','it','its','you','your','we','our','us','i','me','my','with','at','by','from','as',
    'that','this','these','those','can','could','will','would','should','how','what','when','where',
    'which','who','why','much','many','long','get','got','has','have','had','if','about','there',
    'ithrive','software','solutions','please','tell','give','need','want','know','also','more',
    // Generic verbs. Without these, "what monitoring tools do you use" tied on
    // "use" against "What AI stack does iThrive use?" and lost to it.
    'use','used','using','take','takes','taking','make','made','provide','offer','does','doing',
];

/**
 * Fold an Indic question into the English vocabulary the answer book indexes.
 *
 * Returns the original text plus every English term whose trigger appears in
 * it, so a mixed-script question keeps both halves.
 */
function faq_normalise(string $question): string
{
    $extra = [];

    foreach (FAQ_LEXICON as $native => $english) {
        if (mb_strpos($question, $native) !== false) {
            $extra[] = $english;
        }
    }

    return mb_strtolower($question) . ' ' . implode(' ', $extra);
}

/** Content words from a normalised question. */
function faq_terms(string $normalised): array
{
    $words = preg_split('/[^a-z0-9+.#]+/u', $normalised, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $terms = [];

    foreach ($words as $word) {
        if (mb_strlen($word) < 2 || in_array($word, FAQ_STOPWORDS, true)) {
            continue;
        }
        $terms[$word] = true;
    }

    // strval because PHP silently casts a numeric-string array key to int: the
    // word "400" becomes the key 400, and array_keys() hands back an int that
    // str_contains() rejects outright in PHP 8. Any question with a bare number
    // in it -- "how much for 3 developers", "what is the 400ms latency" --
    // would otherwise take down the whole reply with a TypeError.
    return array_map('strval', array_keys($terms));
}

/**
 * Best matching answer, or no match.
 *
 * Scores each entry on how many distinct question terms it covers. A hit in the
 * question text counts double a hit in the auxiliary terms, because the
 * question is what the visitor is actually echoing.
 *
 * @return array{matched: bool, id: string, question: string, text: string, score: int}
 */
function faq_match(string $question): array
{
    $normalised = faq_normalise($question);
    $terms      = faq_terms($normalised);

    if ($terms === []) {
        return ['matched' => false, 'id' => '', 'question' => '', 'text' => '', 'score' => 0];
    }

    $best = ['matched' => false, 'id' => '', 'question' => '', 'text' => '', 'score' => 0];

    foreach (FAQ as $entry) {
        $q     = mb_strtolower($entry['q']);
        $aux   = explode(' ', $entry['terms']);
        $score = 0;

        foreach ($terms as $term) {
            if (str_contains($q, $term)) {
                $score += 2;

                continue;
            }

            $hit = 0;

            foreach ($aux as $word) {
                if ($word === $term) {
                    // An exact term is real evidence — "nda" or "poc" is the
                    // whole question, and it only ever appears in the entry it
                    // belongs to.
                    $hit = 2;

                    break;
                }

                // Prefix match either way, so "providers" finds "provider" and
                // "cloud" finds "clouds". Four characters is short enough to
                // catch plurals and long enough not to collide.
                $shared = min(mb_strlen($term), mb_strlen($word));
                if ($shared >= 4 && mb_substr($term, 0, $shared) === mb_substr($word, 0, $shared)) {
                    $hit = 1;
                }
            }

            $score += $hit;
        }

        if ($score > $best['score']) {
            $best = [
                'matched'  => true,
                'id'       => $entry['id'],
                'question' => $entry['q'],
                'text'     => $entry['a'],
                'score'    => $score,
            ];
        }
    }

    // One incidental word is not a question about that topic. Four is roughly
    // two real terms, or one term echoed straight out of the question — but a
    // three-word question cannot reach four however clearly it is on topic, so
    // the bar drops with the amount of evidence available.
    //
    // It has to drop all the way to 2 when only one term survives, or such a
    // question can never match anything: a single term scores at most 2, so a
    // floor of 3 rejected it however exact the hit was. "How long does a
    // project take?" is printed verbatim on two service pages, and asking the
    // assistant that exact sentence returned the demo boundary reply — every
    // word but "project" is a stopword.
    //
    // Two is still strong evidence rather than an incidental brush: the only
    // ways to score 2 on one term are that it appears in the entry's own
    // question, or that it matches an aux term exactly. A fuzzy prefix match —
    // the weak signal this floor exists to reject — scores 1 and is still out.
    $floor = count($terms) === 1 ? 2 : min(4, max(3, count($terms)));

    if ($best['score'] < $floor) {
        return ['matched' => false, 'id' => '', 'question' => '', 'text' => '', 'score' => $best['score']];
    }

    return $best;
}

/**
 * The demo boundary.
 *
 * Said once, plainly, with a way forward — not repeated apology. Each language
 * carries the same three beats: this demo cannot answer that, the full version
 * can, and I can put a person in front of you now.
 */
const FAQ_DEMO_REPLY = [
    'en' => 'That one is outside what the iThrive AI demo covers — the full version, trained on '
          . 'your own business data, answers questions like it without blinking. I am also not here '
          . 'to talk about anything other than iThrive Software. What I can do right now is connect '
          . 'you to one of our people for a proper business conversation. Say the word, or email %s '
          . 'and we will pick it up straight away.',

    'ta' => 'அந்தக் கேள்வி iThrive AI டெமோவின் வரம்பிற்கு வெளியே உள்ளது — உங்கள் நிறுவனத் தரவில் '
          . 'பயிற்சி பெற்ற முழுப் பதிப்பு அதற்குத் தயங்காமல் பதிலளிக்கும். மேலும், iThrive Software '
          . 'தவிர வேறு எதைப் பற்றியும் நான் பேச அமைக்கப்படவில்லை. இப்போதே எங்கள் நிபுணர் ஒருவரை '
          . 'உங்களுடன் இணைத்து வணிக உரையாடலைத் தொடங்க முடியும். சொல்லுங்கள், அல்லது %s க்கு எழுதுங்கள் '
          . '— உடனே தொடர்பு கொள்கிறோம்.',

    'ml' => 'ആ ചോദ്യം iThrive AI ഡെമോയുടെ പരിധിക്ക് പുറത്താണ് — നിങ്ങളുടെ സ്ഥാപനത്തിന്റെ ഡാറ്റയിൽ '
          . 'പരിശീലിപ്പിച്ച പൂർണ്ണ പതിപ്പ് അതിന് നിഷ്പ്രയാസം ഉത്തരം നൽകും. iThrive Software അല്ലാതെ '
          . 'മറ്റൊന്നിനെക്കുറിച്ചും സംസാരിക്കാൻ ഞാൻ സജ്ജീകരിച്ചിട്ടില്ല. ഇപ്പോൾത്തന്നെ ഞങ്ങളുടെ ഒരു '
          . 'വിദഗ്ധനെ നിങ്ങളുമായി ബന്ധിപ്പിച്ച് ബിസിനസ് സംഭാഷണം തുടങ്ങാം. പറയൂ, അല്ലെങ്കിൽ %s എന്ന '
          . 'വിലാസത്തിൽ എഴുതൂ — ഉടൻ പ്രതികരിക്കാം.',

    'kn' => 'ಆ ಪ್ರಶ್ನೆ iThrive AI ಡೆಮೊದ ವ್ಯಾಪ್ತಿಯ ಹೊರಗಿದೆ — ನಿಮ್ಮ ಸಂಸ್ಥೆಯ ದತ್ತಾಂಶದ ಮೇಲೆ ತರಬೇತಿ ಪಡೆದ '
          . 'ಪೂರ್ಣ ಆವೃತ್ತಿ ಅದಕ್ಕೆ ಸಲೀಸಾಗಿ ಉತ್ತರಿಸುತ್ತದೆ. iThrive Software ಹೊರತುಪಡಿಸಿ ಬೇರೆ ಯಾವುದರ '
          . 'ಬಗ್ಗೆಯೂ ಮಾತನಾಡಲು ನನ್ನನ್ನು ರೂಪಿಸಿಲ್ಲ. ಈಗಲೇ ನಮ್ಮ ತಜ್ಞರೊಬ್ಬರನ್ನು ನಿಮಗೆ ಸಂಪರ್ಕಿಸಿ ವ್ಯಾವಹಾರಿಕ '
          . 'ಚರ್ಚೆ ಆರಂಭಿಸಬಹುದು. ಹೇಳಿ, ಅಥವಾ %s ಗೆ ಬರೆಯಿರಿ — ತಕ್ಷಣ ಸ್ಪಂದಿಸುತ್ತೇವೆ.',

    'te' => 'ఆ ప్రశ్న iThrive AI డెమో పరిధికి వెలుపల ఉంది — మీ సంస్థ డేటాపై శిక్షణ పొందిన పూర్తి '
          . 'వెర్షన్ దానికి అలవోకగా సమాధానం ఇస్తుంది. అలాగే iThrive Software తప్ప మరే విషయం గురించీ '
          . 'మాట్లాడేలా నన్ను రూపొందించలేదు. ఇప్పుడే మా నిపుణుల్లో ఒకరిని మీకు కలిపి వ్యాపార చర్చ '
          . 'ప్రారంభించగలను. చెప్పండి, లేదా %s కు రాయండి — వెంటనే స్పందిస్తాం.',

    'hi' => 'यह सवाल iThrive AI डेमो के दायरे से बाहर है — आपके अपने व्यावसायिक डेटा पर प्रशिक्षित '
          . 'पूर्ण संस्करण ऐसे सवालों का जवाब बिना अटके देता है। साथ ही, iThrive Software के अलावा '
          . 'किसी और विषय पर बात करने के लिए मुझे नहीं बनाया गया है। अभी मैं आपको हमारे किसी विशेषज्ञ '
          . 'से जोड़ सकता हूँ ताकि व्यावसायिक बातचीत शुरू हो सके। बताइए, या %s पर लिखिए — हम तुरंत '
          . 'जवाब देंगे।',
];

/** Lead-in placed before an English answer body when the visitor is not in English. */
const FAQ_LEAD_IN = [
    'en' => '',
    'ta' => 'இதோ iThrive இன் அதிகாரப்பூர்வ பதில்:',
    'ml' => 'ഇതാ iThrive-ന്റെ ഔദ്യോഗിക ഉത്തരം:',
    'kn' => 'ಇಲ್ಲಿದೆ iThrive ನ ಅಧಿಕೃತ ಉತ್ತರ:',
    'te' => 'ఇదిగో iThrive అధికారిక సమాధానం:',
    'hi' => 'यह रहा iThrive का आधिकारिक उत्तर:',
];

/** The demo boundary reply, in the visitor's language. */
function faq_demo_reply(string $lang = 'en'): string
{
    return sprintf(FAQ_DEMO_REPLY[$lang] ?? FAQ_DEMO_REPLY['en'], SITE_EMAIL);
}

/**
 * Answer from the book, or decline.
 *
 * @return array{matched: bool, text: string, id: string}
 */
function faq_answer(string $question, string $lang = 'en'): array
{
    $hit = faq_match($question);

    if (!$hit['matched']) {
        return ['matched' => false, 'text' => faq_demo_reply($lang), 'id' => ''];
    }

    // The answer body stays in English: prices, stack names and product names
    // are English in the source and translating them would introduce drift the
    // demo cannot check. The lead-in keeps the reply in the visitor's language;
    // with an API key the model translates the whole answer.
    $lead = FAQ_LEAD_IN[$lang] ?? '';

    return [
        'matched' => true,
        'id'      => $hit['id'],
        'text'    => $lead === '' ? $hit['text'] : $lead . ' ' . $hit['text'],
    ];
}
