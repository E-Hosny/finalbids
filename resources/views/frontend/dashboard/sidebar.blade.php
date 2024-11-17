<!-- القائمة الجانبية -->
<div class="col-md-3">
    <div class="profile-sidebar">
        <!-- تحرير الملف الشخصي -->
        <div class="edit-profile">
            @if(session('locale') === 'ar')
                <div class="d-flex align-items-center">
                    <div class="icon-container">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <span>تحرير الملف الشخصي</span>
                </div>
            @else
                <div class="d-flex align-items-center">
                    <div class="icon-container">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <span>Edit Profile</span>
                </div>
            @endif
        </div>

        <!-- القائمة الرئيسية -->
        <div class="menu-section">
            <div class="menu-header">
                @if(session('locale') === 'ar')
                    <h5 class="d-flex align-items-center">
                        <div class="icon-container">
                            <i class="fas fa-th-list"></i>
                        </div>
                        <span>القائمة الرئيسية</span>
                    </h5>
                @else
                    <h5 class="d-flex align-items-center">
                        <div class="icon-container">
                            <i class="fas fa-th-list"></i>
                        </div>
                        <span>Main Menu</span>
                    </h5>
                @endif
            </div>

            <div class="menu-items">
                @if(session('locale') === 'ar')
                    <!-- القائمة العربية -->
                    <a href="{{ route('userdashboard') }}" class="menu-link {{ request()->routeIs('userdashboard') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-home"></i>
                        </div>
                        <span>حسابي</span>
                        <i class="fas fa-chevron-left arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('useraddress') }}" class="menu-link {{ request()->routeIs('useraddress') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span>إدارة العنوان</span>
                        <i class="fas fa-chevron-left arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('auction') }}" class="menu-link {{ request()->routeIs('auction') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <span>المزادات</span>
                        <i class="fas fa-chevron-left arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('user.products') }}" class="menu-link {{ request()->routeIs('user.products') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <span>منتجاتي</span>
                        <i class="fas fa-chevron-left arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('logouts') }}" class="menu-link">
                        <div class="icon-container">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <span>تسجيل الخروج</span>
                        <i class="fas fa-chevron-left arrow-icon"></i>
                    </a>
                @else
                    <!-- English Menu -->
                    <a href="{{ route('userdashboard') }}" class="menu-link {{ request()->routeIs('userdashboard') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-home"></i>
                        </div>
                        <span>My Account</span>
                        <i class="fas fa-chevron-right arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('useraddress') }}" class="menu-link {{ request()->routeIs('useraddress') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span>Manage Address</span>
                        <i class="fas fa-chevron-right arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('auction') }}" class="menu-link {{ request()->routeIs('auction') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <span>Auctions</span>
                        <i class="fas fa-chevron-right arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('user.products') }}" class="menu-link {{ request()->routeIs('user.products') ? 'active' : '' }}">
                        <div class="icon-container">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <span>My Products</span>
                        <i class="fas fa-chevron-right arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('logouts') }}" class="menu-link">
                        <div class="icon-container">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <span>Logout</span>
                        <i class="fas fa-chevron-right arrow-icon"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.profile-sidebar {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
}

.edit-profile {
    background-color: #0D3858;
    padding: 18px 20px;
    color: #fff;
}

/* حاوية الأيقونات */
.icon-container {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 15px;
    position: relative;
    overflow: hidden;
}

.icon-container i {
    font-size: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* تنسيق القائمة */
.menu-section {
    padding: 15px;
}

.menu-header {
    margin-bottom: 20px;
    padding: 0 5px;
}

.menu-header h5 {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.menu-items {
    display: flex;
    flex-direction: column;
}

.menu-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #444;
    text-decoration: none;
    border-radius: 6px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.arrow-icon {
    margin-right: auto;
    margin-left: 15px;
    font-size: 12px;
    opacity: 0;
    transition: all 0.3s ease;
    color: #052C65;
}

/* تأثيرات التحويم */
.menu-link:hover {
    background-color: #f8f9fa;
    color: #052C65;
    text-decoration: none;
}

/* تأثير الأيقونة عند التحويم */
@keyframes iconPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2) rotate(5deg); }
    100% { transform: scale(1); }
}

.menu-link:hover .icon-container i {
    animation: iconPulse 0.5s ease;
    color: #052C65;
}

/* الحالة النشطة */
.menu-link.active {
    background-color: #E8F0FE;
    color: #052C65;
    font-weight: 500;
}

.menu-link.active .icon-container i {
    color: #052C65;
    transform: scale(1.1);
}

.menu-link.active .arrow-icon {
    opacity: 1;
}

/* تأثير ظهور القائمة */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.menu-link {
    animation: slideIn 0.3s ease-out forwards;
}

.menu-items a:nth-child(1) { animation-delay: 0.1s; }
.menu-items a:nth-child(2) { animation-delay: 0.2s; }
.menu-items a:nth-child(3) { animation-delay: 0.3s; }
.menu-items a:nth-child(4) { animation-delay: 0.4s; }
.menu-items a:nth-child(5) { animation-delay: 0.5s; }

/* تأثير الضوء عند التحويم */
@keyframes shine {
    from {
        opacity: 0;
        left: -100%;
    }
    50% {
        opacity: 0.5;
    }
    to {
        opacity: 0;
        left: 100%;
    }
}

.menu-link::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    opacity: 0;
}

.menu-link:hover::after {
    animation: shine 0.8s ease-out;
}

/* تحسين عرض الموبايل */
@media (max-width: 768px) {
    .profile-sidebar {
        margin-bottom: 20px;
    }
}

/* تخصيص RTL/LTR */
[dir="rtl"] .arrow-icon {
    transform: rotate(180deg);
}
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">