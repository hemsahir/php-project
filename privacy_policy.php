<?php
include 'language_switch.php';

$labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'home' => 'Home',
        'page' => 'Privacy Policy',
    ],
    'hi' => [
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'home' => 'मुखपृष्ठ',
        'page' => 'गोपनीयता नीति',
    ]
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <title><?= $labels[$lang]['page'] ?></title>
  <link rel="icon" type="image/png" href="assets/uploads/default_logo.png">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<section id="fontSize" class="wrapper body-wrapper" style="font-size: 100%;">
    <div class="bg-wrapper inner-wrapper">
        <div class="breadcam-bg breadcam">
            <div class="container common-container four_content text-center">
                <ul class="breadcrumb">
                    <li><a href="index.php"><?= $labels[$lang]['home'] ?></a></li>
                    <li><a href="#"><?= $labels[$lang]['page'] ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section id="list" class="wrapper list-wrapper">
        <div class="container common-container four_content">
            <h2><?= $labels[$lang]['municipality'] ?></h2>
            <hr>
            <h3><?= $labels[$lang]['page'] ?></h3>
            <div class="policy-content mt-4">
            <?php if ($lang == 'en'): ?>
                <h5>We protect your personal data and do not share it with third parties.</h5>
                <hr>
            <p>
               Nagar Palika Parishad, Shikarpur respects your privacy and takes its responsibilities regarding the security of your customer information very seriously. We are committed to providing you with a professional, valuable and personalized service whilst safeguarding your privacy. This Privacy Policy applies to Nagar Palika Parishad, Shikarpur business. It has been created to explain to you the way in which Nagar Palika Parishad, Shikarpur use your personal data. This information will assist you to determine whether or not to provide us with your personal information.
            </p>

            <p>
                This Privacy Policy applies without exception to all Nagar Palika Parishad, Shikarpur customers. It is applicable for personal data collected from persons located worldwide. We may update this Privacy Policy. We will notify you of all changes through our website at least one month prior to any change being implemented. This Privacy Policy explains the following regarding Nagar Palika Parishad, Shikarpur’ treatment of personal data:
            </p>

            <h5><strong>Definitions of personal data?</strong></h5>
            <p>
                Personal data is any information that allows you to be identified. The types of personal data Nagar Palika Parishad, Shikarpur collect may include details of your name, address, telephone number, email address, fax number and date of birth.
            </p>

            <p>
                We do not collect personal data about your racial and ethnic origin, political opinion, religious beliefs or other beliefs of a similar nature, membership of a trade union, physical or mental health or conditions, sexual life or any other sensitive information.
            </p>

            <h5><strong>Practices and procedures to collect your personal data</strong></h5>
            <p>
                Nagar Palika Parishad, Shikarpur collect personal data from you through the use of enquiry and registration forms, direct personal contact with you and every time you e-mail us your details. We will use your personal data where it is necessary to do so because it is relevant to Nagar Palika Parishad, Shikarpur' dealings with you (i.e. it is relevant to the provision of the services that you have requested from Nagar Palika Parishad, Shikarpur) including for billing, customer service and network management.
            </p>
            <p>
                Without your consent, we will not use your personal data for direct marketing, including the provision of offers for Nagar Palika Parishad, Shikarpur and its third party partners' products and services and customer surveys. We will not process personal information about you without your express consent. Nagar Palika Parishad, Shikarpur will not sell, trade or rent your personal information to others.
            </p>
            <p>
                Nagar Palika Parishad, Shikarpur may disclose your personal data to carefully selected business partners and third party suppliers to whom we engage to provide services. However, other than as set out in this Privacy Policy, Nagar Palika Parishad, Shikarpur will not disclose or share your personal data with any other third party without your express consent unless this is necessary to provide the services or products which you requested when providing us with your personal data or as required by law.
            </p>

            <h5><strong>Direct marketing</strong></h5>
            <p>
                If you have consented at the point of collection to Nagar Palika Parishad, Shikarpur (and/or any third party) providing you with direct marketing material you will be requested to elect the type of media via which this material shall be provided (for example, by post, e-mail, telephone or fax). We will only provide you with such material via your chosen media.
            </p>
            <p>
                If, at any stage, you object to Nagar Palika Parishad, Shikarpur' use of your personal data for direct marketing or to the media in which such material is being sent, you may choose to unsubscribe to its receipt. If you have consented to receive third party direct marketing you will need to unsubscribe directly with that third party.
            </p>

            <h5><strong>Use of "cookies"</strong></h5>
            <p>
                Nagar Palika Parishad, Shikarpur may use "cookies" on our website and its sub-sites. A "cookie" is information that a web site puts on your hard drive so that it can remember pieces of information about you when you next visit the website or a related website. We use cookies to record personal data about you only when you use our web site in order to facilitate your future activities.
            </p>
            <p>
                Unless otherwise notified by us, Nagar Palika Parishad, Shikarpur will not use personal data sent in a cookie for marketing purposes. If you prefer not to receive cookies from our site, you can set your browser to warn you before accepting cookies and refuse the cookie when your browser alerts you to its presence. You can also refuse cookies by turning them off in your browser.
            </p>

            <h5><strong>Security of your personal data</strong></h5>
            <p>
               Nagar Palika Parishad, Shikarpur has in place appropriate technical and organizational security measures to prevent unauthorized or unlawful disclosure or access to or, accidental or unlawful loss of or destruction, or alteration or unauthorized disclosure of or access to, or other damage to your personal data. These measures ensure an appropriate level of security in relation to the risks inherent in the processing and the nature of the personal data to be protected.
            </p>

            <h5><strong>Your rights to your personal data</strong></h5>
            <p>
                We will only keep your information for as long as we are either required to by law or as is relevant for the purposes for which it was collected. During this period, you may contact our officer at any time if you would like to see details of the personal data that we hold about you. You also may inform yourself about the purposes for which your personal data are being used, details of the parties with whom we may share your personal data or to ask us to correct, update, supplement or delete this personal data.
            </p>

            <h5><strong>Nagar Palika Parishad, Shikarpur enforcement of this Privacy Policy</strong></h5>
            <p>
                If you have a question or enquiry about this Privacy Policy or a complaint about the way Nagar Palika Parishad, Shikarpur has used your personal data you should first contact our Data Protection Officer. The Nagar Palika Parishad, Shikarpur' Data Protection Officer is responsible to deal with and respond to all enquiries that come from any client. The Data Protection officer reports directly to the Company Executive Director. The Nagar Palika Parishad, Shikarpur' Executive Officer meets on an "as necessary" basis to discuss our Privacy Policy and any individual complaints or disputes.
            </p>
            <?php else: ?>
                <h5>हम आपके व्यक्तिगत डेटा की सुरक्षा करते हैं और इसे तीसरे पक्ष के साथ साझा नहीं करते हैं।</h5>
                <hr>
                <p>
                    नगर पालिका परिषद, शिकारपुर आपकी गोपनीयता का सम्मान करता है और आपकी ग्राहक जानकारी की सुरक्षा के बारे में अपनी जिम्मेदारियों को बहुत गंभीरता से लेता है। हम आपकी गोपनीयता की सुरक्षा करते हुए आपको एक पेशेवर, मूल्यवान और व्यक्तिगत सेवा प्रदान करने के लिए प्रतिबद्ध हैं। यह गोपनीयता नीति नगर पालिका परिषद, शिकारपुर व्यवसाय पर लागू होती है। यह आपको यह समझाने के लिए बनाई गई है कि नगर पालिका परिषद, शिकारपुर आपके व्यक्तिगत डेटा का उपयोग किस तरह से करता है। यह जानकारी आपको यह तय करने में मदद करेगी कि हमें अपनी व्यक्तिगत जानकारी प्रदान करनी है या नहीं।
                </p>

                <p>
                    यह गोपनीयता नीति बिना किसी अपवाद के सभी नगर पालिका परिषद, शिकारपुर ग्राहकों पर लागू होती है। यह दुनिया भर में स्थित व्यक्तियों से एकत्रित व्यक्तिगत डेटा के लिए लागू है। हम इस गोपनीयता नीति को अपडेट कर सकते हैं। हम किसी भी बदलाव के लागू होने से कम से कम एक महीने पहले आपको हमारी वेबसाइट के माध्यम से सभी बदलावों के बारे में सूचित करेंगे। यह गोपनीयता नीति नगर पालिका परिषद, शिकारपुर के व्यक्तिगत डेटा के उपचार के बारे में निम्नलिखित बताती है:
                </p>

                <h5><strong>व्यक्तिगत डेटा की परिभाषा?</strong></h5>
                <p>
                    व्यक्तिगत डेटा वह जानकारी है जिससे आपकी पहचान की जा सके। नगर पालिका परिषद, शिकारपुर द्वारा एकत्रित किए जाने वाले व्यक्तिगत डेटा में आपका नाम, पता, टेलीफोन नंबर, ईमेल पता, फैक्स नंबर और जन्म तिथि का विवरण शामिल हो सकता है।
                </p>

                <p>
                    हम आपकी नस्लीय और जातीय उत्पत्ति, राजनीतिक राय, धार्मिक विश्वास या इसी प्रकार की अन्य मान्यताओं, ट्रेड यूनियन की सदस्यता, शारीरिक या मानसिक स्वास्थ्य या स्थिति, यौन जीवन या किसी अन्य संवेदनशील जानकारी के बारे में व्यक्तिगत डेटा एकत्र नहीं करते हैं।
                </p>

                <h5><strong>डेटा संग्रह की प्रक्रियाएं</strong></h5>
                <p>
                    नगर पालिका परिषद, शिकारपुर पूछताछ और पंजीकरण फ़ॉर्म के उपयोग, आपके साथ सीधे व्यक्तिगत संपर्क और हर बार जब आप हमें अपना विवरण ईमेल करते हैं, के माध्यम से आपसे व्यक्तिगत डेटा एकत्र करता है। हम आपके व्यक्तिगत डेटा का उपयोग तब करेंगे जब ऐसा करना आवश्यक हो क्योंकि यह नगर पालिका परिषद, शिकारपुर के आपके साथ व्यवहार के लिए प्रासंगिक है (यानी यह उन सेवाओं के प्रावधान के लिए प्रासंगिक है जिन्हें आपने नगर पालिका परिषद, शिकारपुर से अनुरोध किया है) जिसमें बिलिंग, ग्राहक सेवा और नेटवर्क प्रबंधन शामिल हैं।
                </p>
                <p>
                    आपकी सहमति के बिना, हम आपके व्यक्तिगत डेटा का उपयोग प्रत्यक्ष विपणन के लिए नहीं करेंगे, जिसमें नगर पालिका परिषद, शिकारपुर और उसके तीसरे पक्ष के भागीदारों के उत्पादों और सेवाओं और ग्राहक सर्वेक्षणों के लिए ऑफ़र का प्रावधान शामिल है। हम आपकी स्पष्ट सहमति के बिना आपके बारे में व्यक्तिगत जानकारी संसाधित नहीं करेंगे। नगर पालिका परिषद, शिकारपुर आपकी व्यक्तिगत जानकारी को दूसरों को नहीं बेचेगा, व्यापार नहीं करेगा या किराए पर नहीं देगा।
                </p>
                <p>
                    नगर पालिका परिषद, शिकारपुर आपके व्यक्तिगत डेटा को सावधानीपूर्वक चुने गए व्यावसायिक भागीदारों और तीसरे पक्ष के आपूर्तिकर्ताओं को प्रकट कर सकता है, जिन्हें हम सेवाएँ प्रदान करने के लिए नियुक्त करते हैं। हालाँकि, इस गोपनीयता नीति में निर्धारित किए गए के अलावा, नगर पालिका परिषद, शिकारपुर आपकी व्यक्तिगत सहमति के बिना किसी अन्य तीसरे पक्ष के साथ आपके व्यक्तिगत डेटा का खुलासा या साझा नहीं करेगा, जब तक कि यह उन सेवाओं या उत्पादों को प्रदान करने के लिए आवश्यक न हो, जिनका आपने हमें अपना व्यक्तिगत डेटा प्रदान करते समय अनुरोध किया था या कानून द्वारा आवश्यक हो।
                </p>

                <h5><strong>प्रत्यक्ष विपणन</strong></h5>
                <p>
                    यदि आपने नगर पालिका परिषद, शिकारपुर (और/या किसी तीसरे पक्ष) को आपको प्रत्यक्ष विपणन सामग्री प्रदान करने के लिए संग्रह के समय सहमति दी है, तो आपसे मीडिया के प्रकार का चयन करने का अनुरोध किया जाएगा जिसके माध्यम से यह सामग्री प्रदान की जाएगी (उदाहरण के लिए, डाक, ई-मेल, टेलीफोन या फैक्स द्वारा)। हम आपको ऐसी सामग्री केवल आपके द्वारा चुने गए मीडिया के माध्यम से ही प्रदान करेंगे।
                </p>
                <p>
                    यदि किसी भी स्तर पर आप नगर पालिका परिषद, शिकारपुर द्वारा आपके व्यक्तिगत डेटा का प्रत्यक्ष विपणन या उस मीडिया के लिए उपयोग करने पर आपत्ति करते हैं जिसमें ऐसी सामग्री भेजी जा रही है, तो आप इसकी प्राप्ति से सदस्यता समाप्त करने का विकल्प चुन सकते हैं। यदि आपने तीसरे पक्ष से प्रत्यक्ष विपणन प्राप्त करने के लिए सहमति दी है, तो आपको उस तीसरे पक्ष से सीधे सदस्यता समाप्त करनी होगी।
                </p>

                <h5><strong>"कुकीज़" का उपयोग</strong></h5>
                <p>
                   नगर पालिका परिषद, शिकारपुर हमारी वेबसाइट और इसकी उप-साइटों पर "कुकीज़" का उपयोग कर सकता है। "कुकी" वह जानकारी है जिसे एक वेबसाइट आपकी हार्ड ड्राइव पर रखती है ताकि जब आप अगली बार वेबसाइट या उससे संबंधित वेबसाइट पर जाएँ तो वह आपके बारे में जानकारी के कुछ अंशों को याद रख सके। हम कुकीज़ का उपयोग केवल तभी आपके बारे में व्यक्तिगत डेटा रिकॉर्ड करने के लिए करते हैं जब आप हमारी वेबसाइट का उपयोग करते हैं ताकि आपकी भविष्य की गतिविधियों को सुविधाजनक बनाया जा सके।
                </p>
                <p>
                    जब तक कि हम अन्यथा सूचित न करें, नगर पालिका परिषद, शिकारपुर विपणन उद्देश्यों के लिए कुकी में भेजे गए व्यक्तिगत डेटा का उपयोग नहीं करेगा। यदि आप हमारी साइट से कुकीज़ प्राप्त नहीं करना चाहते हैं, तो आप अपने ब्राउज़र को कुकीज़ स्वीकार करने से पहले आपको चेतावनी देने के लिए सेट कर सकते हैं और जब आपका ब्राउज़र आपको इसकी उपस्थिति के बारे में सचेत करता है तो कुकी को अस्वीकार कर सकते हैं। आप अपने ब्राउज़र में उन्हें बंद करके भी कुकीज़ को अस्वीकार कर सकते हैं।
                </p>

                <h5><strong>आपके व्यक्तिगत डेटा की सुरक्षा</strong></h5>
                <p>
                    नगर पालिका परिषद, शिकारपुर ने आपके व्यक्तिगत डेटा के अनधिकृत या गैरकानूनी प्रकटीकरण या एक्सेस या आकस्मिक या गैरकानूनी नुकसान या विनाश, या परिवर्तन या अनधिकृत प्रकटीकरण या एक्सेस या अन्य क्षति को रोकने के लिए उचित तकनीकी और संगठनात्मक सुरक्षा उपाय किए हैं। ये उपाय प्रसंस्करण में निहित जोखिमों और संरक्षित किए जाने वाले व्यक्तिगत डेटा की प्रकृति के संबंध में सुरक्षा का एक उचित स्तर सुनिश्चित करते हैं।
                </p>

                <h5><strong>आपके व्यक्तिगत डेटा पर आपके अधिकार</strong></h5>
                <p>
                    हम आपकी जानकारी को केवल तब तक रखेंगे जब तक हमें कानून द्वारा ऐसा करने की आवश्यकता होगी या जिस उद्देश्य के लिए इसे एकत्र किया गया था, उसके लिए प्रासंगिक होगा। इस अवधि के दौरान, यदि आप हमारे पास आपके बारे में मौजूद व्यक्तिगत डेटा का विवरण देखना चाहते हैं, तो आप किसी भी समय हमारे अधिकारी से संपर्क कर सकते हैं। आप अपने व्यक्तिगत डेटा का उपयोग किस उद्देश्य से किया जा रहा है, उन पक्षों का विवरण जिनके साथ हम आपका व्यक्तिगत डेटा साझा कर सकते हैं या हमसे इस व्यक्तिगत डेटा को सही करने, अपडेट करने, पूरक करने या हटाने के लिए कह सकते हैं, इसके बारे में भी जानकारी प्राप्त कर सकते हैं।
                </p>

                <h5><strong>नगर पालिका परिषद, शिकारपुर द्वारा इस गोपनीयता नीति का प्रवर्तन</strong></h5>
                <p>
                    यदि आपके पास इस गोपनीयता नीति के बारे में कोई प्रश्न या पूछताछ है या नगर पालिका परिषद, शिकारपुर द्वारा आपके व्यक्तिगत डेटा का उपयोग करने के तरीके के बारे में कोई शिकायत है, तो आपको सबसे पहले हमारे डेटा सुरक्षा अधिकारी से संपर्क करना चाहिए। नगर पालिका परिषद, शिकारपुर का डेटा सुरक्षा अधिकारी किसी भी ग्राहक से आने वाली सभी पूछताछ से निपटने और उनका जवाब देने के लिए जिम्मेदार है। डेटा सुरक्षा अधिकारी सीधे कंपनी के कार्यकारी निदेशक को रिपोर्ट करता है। नगर पालिका परिषद, शिकारपुर का कार्यकारी अधिकारी हमारी गोपनीयता नीति और किसी भी व्यक्तिगत शिकायत या विवाद पर चर्चा करने के लिए "आवश्यकतानुसार" बैठक करता है।
                </p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>
