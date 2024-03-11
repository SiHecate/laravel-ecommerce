# Laravel E-Alışveriş API Dökümantasyonu

Bu dökümantasyon, temel özelliklere sahip bir e-alışveriş sitesi için Laravel tabanlı bir backend API'yi tanıtmaktadır. API aşağıdaki özellikleri içermektedir:

## Tasarım ve Programlama Kalıpları

Laravel ve PHP ile ilk projemi geliştirirken, kendimi daha fazla geliştirmek amacıyla çeşitli programlama desenleri ve yapıları öğrenmeye odaklandım.
Uygulama geliştirme sürecinde, veri erişimi ve işlemleri gibi temel işlevler repository pattern ve service layer dizaynına uygun bir şekilde yapılandırılmıştır. Bu sayede kodun daha düzenli ve yönetilebilir olması sağlanmıştır.

Ayrıca, çeşitli tasarım ve programlama kalıplarından yararlanılmıştır. Bu kalıplar, kodun daha organize ve yönetilebilir olmasını sağlamak amacıyla kullanılmıştır. Özellikle şu kavramlar üzerinde durulmuştur:

- **Observer Pattern**: Bu desen, bir nesnenin durumu değiştiğinde ve bu durumu başka nesnelerin etkilemesi gerektiğinde kullanılır. Uygulama içinde bu desen kullanılarak bir nesnenin durum değişiklikleri diğer nesnelere haber verilmiş ve bu duruma göre uygun işlemler gerçekleştirilmiştir.

- **Factory Pattern**: Fabrika tasarım deseni, nesne oluşturma sürecini merkezi hale getirir ve bu sayede nesne yaratma işlemlerinin yönetimini kolaylaştırır. Uygulama içinde bu desen kullanılarak farklı tiplerde nesnelerin oluşturulması ve yönetilmesi sağlanmıştır.

- **Dependency Injection (Bağımlılık Enjeksiyonu)**: Bu yöntem, bir nesnenin diğer nesnelerle olan ilişkilerinin dışarıdan sağlanmasıdır. Bu sayede nesneler arasındaki bağımlılıklar azaltılır ve test edilebilirlik artar. Uygulama içinde bu yöntem kullanılarak nesneler arasındaki bağımlılıkların yönetimi sağlanmıştır.

Uygulama, sürekli olarak geliştirilmeye ve yeni özellikler eklenmeye açık bir durumdadır. Bu sayede, kullanıcı deneyimini geliştirmek ve işlevselliği artırmak amacıyla sürekli olarak güncellemeler yapılabilir.

## Özellikler

1.  **Ürün Yönetimi**: API, ürünlerin eklenmesi, düzenlenmesi, silinmesi ve listelenmesi gibi temel ürün yönetimi işlevlerini sağlar.

    - Ürün Ekleme: Yeni ürünlerin sisteme eklenmesini sağlar.
    - Ürün Düzenleme: Varolan ürünlerin bilgilerinin güncellenmesine olanak tanır.
    - Ürün Kaldırma: Sistemden belirli bir ürünün kaldırılmasını sağlar.
    - Ürün Stok Takip Sistemi: Ürünlerin stok durumlarının kontrolünü sağlar.
    - Ürün Listeleme: Mevcut ürünlerin listelenmesini sağlar.

2.  **Alışveriş Sepeti İşlemleri**: Kullanıcılar, alışveriş sepetlerine ürün ekleyebilir, çıkarabilir ve sepetlerini görüntüleyebilirler.

    - Sepete Ürün Ekleme: Kullanıcılar sepetlerine yeni ürünler ekleyebilirler.
    - Sepetteki Ürünleri Güncelleme: Mevcut ürünlerin miktarını veya özelliklerini güncelleyebilirler.
    - Sepetteki Ürünleri Kaldırma: Sepetteki belirli bir ürünü kaldırabilirler.
    - Sepetteki Ürünleri Görüntüleme: Kullanıcılar sepetlerinde bulunan ürünleri listeleyebilirler.

3.  **Kullanıcı Bilgileri Yönetimi**: Kullanıcıların kayıt olması, giriş yapması ve profillerini güncellemesi gibi kullanıcı bilgileri yönetim işlemleri API tarafından desteklenir. Kullanıcı işlemlerini gerçekleştirmek için Stripe kullanılmıştır

    - Kullanıcı Kaydı: Yeni kullanıcıların sisteme kaydolmasını sağlar.
    - Kullanıcı Girişi: Kayıtlı kullanıcıların sisteme giriş yapmasını sağlar.
    - Kullanıcı Silme: Mevcut kullanıcıların hesaplarını silmelerine olanak tanır.
    - Kullanıcı Bilgileri Yönetimi: Kullanıcılar, profil bilgilerini (adres, iletişim bilgileri vb.) güncelleyebilirler.

4.  **Ticket Sistemi**: Kullanıcılar, destek talepleri oluşturabilir, bu taleplercd i görüntüleyebilir ve yanıtlarını takip edebilirler.

    - Destek Talepleri Oluşturma: Kullanıcılar, destek talepleri oluşturabilir.
    - Talepleri Görüntüleme: Kullanıcılar, oluşturdukları destek taleplerini görüntüleyebilir.
    - Yanıtları Takip Etme: Kullanıcılar, destek taleplerine gelen yanıtları takip edebilir.
    - Bu sistem, kullanıcılar ile satıcı arasındaki iletişimi sağlar.

5.  **Ödeme İşlemleri**: Uygulama, ödeme işlemleri için Stripe entegrasyonunu kullanmaktadır. Kullanıcılar, alışverişlerini güvenli bir şekilde tamamlayabilirler.

    - Kullanıcının sepetindeki ürünleri otomatik olarak alıp, ödeme işlemlerini gerçekleştirir.

## Dökümantasyon ve Test

Geliştiricilere dökümantasyon amacıyla, Laravel projelerinde kullanılan bir eklenti olan "laravel-request-docs" tercih edilmiştir. Bu eklenti sayesinde geliştirme sürecinde API'ların listesini görüntüleyebilir ve API'larla testler gerçekleştirebilirsiniz.

Localhost üzerinden http://127.0.0.1:8000/request-docs# adresiyle erişim sağlanabilir.

API, doğrudan kullanıma hazır bir şekilde tasarlanmıştır. Composer işlemlerini tamamladıktan sonra, API'yi hemen kullanılmaya başlanabilir.
