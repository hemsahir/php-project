<?php
include 'language_switch.php';

$labels = [
    'en' => [
        'municipality' => 'Municipal Council, Shikarpur, Bulandshahr',
        'home' => 'Home',
        'page' => 'Refund and Cancellation Policy',
    ],
    'hi' => [
        'municipality' => 'नगर पालिका परिषद, शिकारपुर, बुलन्दशहर',
        'home' => 'मुखपृष्ठ',
        'page' => 'धन वापसी और रद्दीकरण नीति',
    ]
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <title><?= $labels[$lang]['page'] ?></title>
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
            <h5><strong>1. Amount once paid through the payment gateway shall not be refunded other than in the following circumstances:</strong></h5>
            <p>
               a. Multiple times debiting of Customer’s Card/Bank Account due to technical error OR Customer's account being debited with excess amount in a single transaction due to technical error. In such cases, excess amount excluding Payment Gateway charges would be refunded to the Customer.</p>
               <p>b. Due to technical error, payment being charged on the Customer’s Card/Bank Account but the enrolment for the examination is unsuccessful. Customer would be provided with the enrolment by Nagar Palika Parishad, Shikarpur at no extra cost. However, if in such cases, Customer wishes to seek refund of the amount, he/she would be refunded net the amount, after deduction of Payment Gateway charges or any other charges.</p>
            <h5><strong>2. The Customer will have to make an application for refund along with the transaction number and original payment receipt if any generated at the time of making payments.</strong></h5>
            <br>

            <h5><strong>3. The application in the prescribed format should be sent to official address of Nagar Palika Parishad, Shikarpur.</strong></h5>
            <br>

            <h5><strong>4. The application will be processed manually and after verification, if the claim is found valid, the amount received in excess will be adjusted by Nagar Palika Parishad, Shikarpur for next financial year Tax Bill.</strong></h5>
            <br>

            <h5><strong>5. Nagar Palika Parishad, Shikarpur assumes no responsibility and shall incur no liability if it is unable to affect any Payment Instruction(s) on the Payment Date owing to any one or more of the following circumstances:</strong></h5><br>

            <p>a. If the Payment Instruction(s) issued by you is/are incomplete, inaccurate, and invalid and delayed.</p>
            <p>b. If the Payment Account has insufficient funds/limits to cover for the amount as mentioned in the Payment Instruction(s)</p>
            <p>c. If the funds available in the Payment Account are under any encumbrance or charge.</p>
            <p>d. If your Bank or the NCC refuses or delays honoring the Payment Instruction(s)<p>
            <p>e. Circumstances beyond the control of Nagar Palika Parishad, Shikarpur (including, but not limited to, fire, flood, natural disasters, bank strikes, power failure, systems failure like computer or telephone lines breakdown due to an unforeseeable cause or interference from an outside force)<p>
            <p>f. In case the payment is not affected for any reason, you will be intimated about the failed payment by an e-mail<p>

             <h5><strong>6. User agrees that Nagar Palika Parishad, Shikarpur , in its sole discretion, for any or no reason, and without penalty, may suspend or terminate his/her account (or any part thereof) or use of the Services and remove and discard all or any part of his/her account, user profile, or his/her recipient profile, at any time. Nagar Palika Parishad, Shikarpur may also in its sole discretion and at any time discontinue providing access to the Services, or any part thereof, with or without notice. User agrees that any termination of his/her access to the Services or any account he/she may have or portion thereof may be effected without prior notice, and also agrees that Nagar Palika Parishad, Shikarpur will not be liable to user or any third party for any such termination. Any suspected, fraudulent, abusive or illegal activity may be referred to appropriate law enforcement authorities. These remedies are in addition to any other remedies Nagar Palika Parishad, Shikarpur may have at law or in equity. Upon termination for any reason, user agrees to immediately stop using the Services.</strong></h5>
             <br>

            <h5><strong>7. Nagar Palika Parishad, Shikarpur may elect to resolve any dispute, controversy or claim arising out of or relating to this Agreement or Service provided in connection with this Agreement by binding arbitration in accordance with the provisions of the Indian Arbitration & Conciliation Act, 1996. Any such dispute, controversy or claim shall be arbitrated on an individual basis and shall not be consolidated in any arbitration with any claim or controversy of any other party.</strong></h5>

            <?php else: ?>
                <h5><strong>1. भुगतान गेटवे के माध्यम से एक बार भुगतान की गई राशि निम्नलिखित परिस्थितियों के अलावा वापस नहीं की जाएगी:</strong></h5>
            <p>
               a. तकनीकी त्रुटि के कारण ग्राहक के कार्ड/बैंक खाते से कई बार डेबिट होना या तकनीकी त्रुटि के कारण एक ही लेनदेन में ग्राहक के खाते से अधिक राशि डेबिट होना। ऐसे मामलों में, भुगतान गेटवे शुल्क को छोड़कर अतिरिक्त राशि ग्राहक को वापस कर दी जाएगी।</p>
               <p>b. तकनीकी त्रुटि के कारण, ग्राहक के कार्ड/बैंक खाते से भुगतान लिया जा रहा है, लेकिन परीक्षा के लिए नामांकन असफल है। ग्राहक को नगर पालिका परिषद, शिकारपुर द्वारा बिना किसी अतिरिक्त लागत के नामांकन प्रदान किया जाएगा। हालाँकि, यदि ऐसे मामलों में, ग्राहक राशि की वापसी चाहता है, तो उसे भुगतान गेटवे शुल्क या किसी अन्य शुल्क की कटौती के बाद शुद्ध राशि वापस कर दी जाएगी।</p>
            <h5><strong>2. ग्राहक को रिफंड के लिए आवेदन करना होगा, साथ ही भुगतान करते समय प्राप्त लेनदेन संख्या और मूल भुगतान रसीद (यदि कोई हो) भी साथ में देनी होगी।</strong></h5>
            <br>

            <h5><strong>3. निर्धारित प्रारूप में आवेदन नगर पालिका परिषद, शिकारपुर के आधिकारिक पते पर भेजा जाना चाहिए।.</strong></h5>
            <br>

            <h5><strong>4. आवेदन को मैन्युअल रूप से संसाधित किया जाएगा और सत्यापन के बाद, यदि दावा वैध पाया जाता है, तो अधिक प्राप्त धनराशि को नगर पालिका परिषद, शिकारपुर द्वारा अगले वित्तीय वर्ष के कर बिल के लिए समायोजित किया जाएगा।.</strong></h5>
            <br>

            <h5><strong>5. नगर पालिका परिषद, शिकारपुर कोई जिम्मेदारी नहीं लेती है और कोई देयता नहीं उठाती है यदि वह निम्नलिखित परिस्थितियों में से किसी एक या अधिक के कारण भुगतान तिथि पर किसी भी भुगतान निर्देश को प्रभावित करने में असमर्थ है:</strong></h5><br>

            <p>a. यदि आपके द्वारा जारी किया गया भुगतान निर्देश अधूरा, गलत, अमान्य और विलंबित है|</p>
            <p>b. यदि भुगतान खाते में भुगतान निर्देश(ओं) में उल्लिखित राशि को कवर करने के लिए अपर्याप्त धन/सीमाएं हैं|</p>
            <p>c. यदि भुगतान खाते में उपलब्ध धनराशि किसी भार या प्रभार के अधीन है|</p>
            <p>d. यदि आपका बैंक या एनसीसी भुगतान निर्देश का सम्मान करने से इनकार करता है या देरी करता है<p>
            <p>e.नगर पालिका परिषद, शिकारपुर के नियंत्रण से परे परिस्थितियाँ (जिनमें आग, बाढ़, प्राकृतिक आपदाएँ, बैंक हड़ताल, बिजली की विफलता, अप्रत्याशित कारण या बाहरी ताकतों के हस्तक्षेप से कंप्यूटर या टेलीफोन लाइनों के टूटने जैसी प्रणाली विफलता शामिल है, लेकिन इन्हीं तक सीमित नहीं है)<p>
            <p>f.यदि किसी कारणवश भुगतान प्रभावित नहीं होता है, तो आपको ई-मेल द्वारा भुगतान विफल होने की सूचना दी जाएगी।<p>

             <h5><strong>6. उपयोगकर्ता इस बात से सहमत है कि नगर पालिका परिषद, शिकारपुर अपने विवेकानुसार, किसी भी कारण से या बिना किसी दंड के, उसके खाते (या उसके किसी भाग) या सेवाओं के उपयोग को निलंबित या समाप्त कर सकता है और उसके खाते, उपयोगकर्ता प्रोफ़ाइल या उसके प्राप्तकर्ता प्रोफ़ाइल के सभी या किसी भाग को किसी भी समय हटा या त्याग सकता है। नगर पालिका परिषद, शिकारपुर अपने विवेकानुसार और किसी भी समय, नोटिस के साथ या बिना नोटिस के सेवाओं या उसके किसी भाग तक पहुँच प्रदान करना बंद कर सकता है। उपयोगकर्ता इस बात से सहमत है कि सेवाओं या उसके किसी खाते या उसके किसी भाग तक उसकी पहुँच की समाप्ति बिना किसी पूर्व सूचना के की जा सकती है, और यह भी सहमत है कि नगर पालिका परिषद, शिकारपुर ऐसे किसी भी समाप्ति के लिए उपयोगकर्ता या किसी तीसरे पक्ष के प्रति उत्तरदायी नहीं होगी। किसी भी संदिग्ध, धोखाधड़ी, अपमानजनक या अवैध गतिविधि को उचित कानून प्रवर्तन अधिकारियों को भेजा जा सकता है। ये उपाय नगर पालिका परिषद, शिकारपुर के पास कानून या इक्विटी में मौजूद किसी भी अन्य उपाय के अतिरिक्त हैं। किसी भी कारण से समाप्ति पर, उपयोगकर्ता सेवाओं का उपयोग तुरंत बंद करने के लिए सहमत है।.</strong></h5>
             <br>

            <h5><strong>7. नगर पालिका परिषद, शिकारपुर इस अनुबंध या इस अनुबंध के संबंध में प्रदान की गई सेवा से उत्पन्न या इससे संबंधित किसी भी विवाद, मतभेद या दावे को भारतीय मध्यस्थता और सुलह अधिनियम, 1996 के प्रावधानों के अनुसार बाध्यकारी मध्यस्थता द्वारा हल करने का विकल्प चुन सकती है। ऐसा कोई भी विवाद, विवाद या दावा व्यक्तिगत आधार पर मध्यस्थता किया जाएगा और किसी अन्य पक्ष के किसी भी दावे या विवाद के साथ किसी भी मध्यस्थता में समेकित नहीं किया जाएगा।.</strong></h5>
            <?php endif; ?>
            </div>
        </div>
    </section>
</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>
