<section class="ruby-support-section">
    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6">
            <article class="ruby-support-card">
                <div class="ruby-support-card__icon"><i class="fas fa-headset"></i></div>
                <h3 class="ruby-support-card__title">บริการและซัพพอร์ต</h3>
                <p class="ruby-support-card__desc">
                    ทีมงาน RUBYSHOP พร้อมช่วยตั้งแต่เลือกสินค้า วิธีใช้งาน ไปจนถึงบริการหลังการขาย ให้คุณทำงานต่อได้เร็วและมั่นใจ
                </p>
                <a href="{{ url('/contact') }}" class="ruby-support-card__btn">SERVICE &amp; SUPPORT</a>
            </article>

            <article class="ruby-support-card">
                <div class="ruby-support-card__icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3 class="ruby-support-card__title">ซื้อสินค้าได้ที่ไหน</h3>
                <p class="ruby-support-card__desc">
                    สั่งซื้อออนไลน์สะดวก หรือเข้าดูสินค้าหน้าร้านได้ที่ RUBYSHOP เพื่อเปรียบเทียบรุ่นและรับคำแนะนำจากทีมงานโดยตรง
                </p>
                <a href="{{ url('/contact') }}" class="ruby-support-card__btn">FIND A RETAILER</a>
            </article>

            <article class="ruby-support-card">
                <div class="ruby-support-card__icon"><i class="fas fa-comments"></i></div>
                <h3 class="ruby-support-card__title">ต้องการความช่วยเหลือ?</h3>
                <p class="ruby-support-card__desc">
                    หากมีคำถามเรื่องเครื่องมือ สเปก หรือการใช้งาน ทีมเราพร้อมตอบเร็วผ่านหลายช่องทาง เพื่อช่วยให้คุณตัดสินใจได้ง่ายขึ้น
                </p>
                <a href="{{ url('/contact') }}" class="ruby-support-card__btn">CONTACT US</a>
            </article>

            <article class="ruby-support-card">
                <div class="ruby-support-card__icon"><i class="fas fa-wrench"></i></div>
                <h3 class="ruby-support-card__title">ข้อมูลการรับประกัน</h3>
                <p class="ruby-support-card__desc">
                    สินค้าอยู่ในเงื่อนไขรับประกัน เราดูแลงานซ่อมโดยไม่คิดค่าแรง หมายเหตุ: ไม่รวมค่าอะไหล่และความเสียหายจากการใช้งานผิดประเภท
                </p>
                <a href="{{ url('/contact') }}" class="ruby-support-card__btn">LEARN MORE</a>
            </article>
        </div>
    </div>
</section>

<section class="ruby-join-section" data-ruby-join-section>
    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="ruby-join-section__card text-center">
            <i class="fas fa-tools ruby-join-section__icon"></i>
            <h2 class="ruby-join-section__title">JOIN RUBYSHOP</h2>
            <p class="ruby-join-section__desc">
                สมัครสมาชิก RUBYSHOP เพื่อจัดการข้อมูลเครื่องมือของคุณในที่เดียว รับข่าวสารสินค้าใหม่ รีวิวจากผู้ใช้งานจริง และสิทธิพิเศษสำหรับสมาชิก
            </p>
            <a href="{{ url('/login') }}" class="ruby-join-section__btn">SIGN UP NOW</a>
        </div>
    </div>
</section>

<style>
    .ruby-support-section {
        background: #f3f4f6;
    }

    .ruby-support-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px 18px;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 100%;
    }

    .ruby-support-card__icon {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        background: #fee2e2;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .ruby-support-card__title {
        margin: 0;
        font-size: 1.25rem;
        line-height: 1.3;
        font-weight: 800;
        color: #111827;
    }

    .ruby-support-card__desc {
        margin: 0;
        font-size: 0.98rem;
        line-height: 1.7;
        color: #374151;
        flex: 1 1 auto;
    }

    .ruby-support-card__btn {
        margin-top: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 42px;
        border-radius: 10px;
        background: #ef4444;
        color: #fff !important;
        font-weight: 700;
        text-decoration: none !important;
        transition: background-color .2s ease;
    }

    .ruby-support-card__btn:hover {
        background: #dc2626;
    }

    .ruby-join-section {
        background: #f3f4f6;
    }

    .ruby-join-section__card {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border-radius: 18px;
        padding: 30px 18px;
        box-shadow: 0 16px 30px rgba(127, 29, 29, 0.18);
    }

    .ruby-join-section__icon {
        font-size: 2rem;
        color: #fff;
        margin-bottom: 10px;
    }

    .ruby-join-section__title {
        margin: 0;
        color: #fff;
        font-size: clamp(1.8rem, 4vw, 2.4rem);
        font-weight: 900;
        letter-spacing: .02em;
    }

    .ruby-join-section__desc {
        max-width: 760px;
        margin: 14px auto 0;
        color: #fff;
        line-height: 1.7;
        font-size: 1rem;
    }

    .ruby-join-section__btn {
        margin-top: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 20px;
        border-radius: 10px;
        font-weight: 800;
        color: #fff !important;
        text-decoration: none !important;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: rgba(17, 24, 39, 0.95);
    }

    @media (max-width: 767px) {
        .ruby-join-section__card {
            border-radius: 12px;
            padding: 22px 14px;
        }

        .ruby-support-card {
            padding: 16px 14px;
            border-radius: 12px;
        }

        .ruby-support-card__title {
            font-size: 1.1rem;
        }

        .ruby-support-card__desc {
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .ruby-join-section__desc {
            font-size: 0.94rem;
            line-height: 1.65;
        }
    }
</style>

<script>
    (function () {
        var section = document.querySelector('[data-ruby-join-section]');
        if (!section) return;

        var node = section.nextSibling;
        while (node) {
            if (node.nodeType === Node.TEXT_NODE) {
                if ((node.textContent || '').trim() === '') {
                    var t = node;
                    node = node.nextSibling;
                    t.remove();
                    continue;
                }
                break;
            }

            if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'P') {
                var normalized = (node.innerHTML || '')
                    .replace(/&nbsp;|\u00a0/gi, '')
                    .replace(/<br\s*\/?>/gi, '')
                    .trim();

                if (normalized === '' && (node.textContent || '').trim() === '') {
                    var p = node;
                    node = node.nextSibling;
                    p.remove();
                    continue;
                }
            }

            break;
        }
    })();
</script>
