<!-- القائمة الجانبية -->
<div class="col-md-3">
    <div class="profile-sidebar">
        <!-- تحرير الملف الشخصي -->
        <div class="edit-profile">
            @if(session('locale') === 'ar')
                <span><i class="fas fa-user-edit"></i> تحرير الملف الشخصي</span>
            @else
                <span><i class="fas fa-user-edit"></i> Edit Profile</span>
            @endif
        </div>

        <!-- القائمة الرئيسية -->
        <div class="menu-section">
            <div class="menu-header">
                @if(session('locale') === 'ar')
                    <h5><i class="fas fa-th-list left-icon"></i> القائمة الرئيسية</h5>
                @else
                    <h5><i class="fas fa-th-list left-icon"></i> Main Menu</h5>
                @endif
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <ul class="menu-items">
                @if(session('locale') === 'ar')
                    <!-- حسابي -->
                    <li>
                        <a href="{{ route('userdashboard') }}" class="menu-link {{ request()->routeIs('userdashboard') ? 'active' : '' }}">
                            <i class="fas fa-home menu-icon"></i>
                            <span>حسابي</span>
                            <i class="fas fa-chevron-left arrow-icon"></i>
                        </a>
                    </li>
                    <!-- إدارة العنوان -->
                    <li>
                        <a href="{{ route('useraddress') }}" class="menu-link {{ request()->routeIs('useraddress') ? 'active' : '' }}">
                            <i class="fas fa-map-marked-alt menu-icon"></i>
                            <span>إدارة العنوان</span>
                            <i class="fas fa-chevron-left arrow-icon"></i>
                        </a>
                    </li>
                    <!-- المزادات -->
                    <li>
                        <a href="{{ route('auction') }}" class="menu-link {{ request()->routeIs('auction') ? 'active' : '' }}">
                            <i class="fas fa-gavel menu-icon"></i>
                            <span>المزادات</span>
                            <i class="fas fa-chevron-left arrow-icon"></i>
                        </a>
                    </li>
                    <!-- منتجاتي -->
                    <li>
                        <a href="{{ route('user.products') }}" class="menu-link {{ request()->routeIs('user.products') ? 'active' : '' }}">
                            <i class="fas fa-box-open menu-icon"></i>
                            <span>منتجاتي</span>
                            <i class="fas fa-chevron-left arrow-icon"></i>
                        </a>
                    </li>
                    <!-- تسجيل الخروج -->
                    <li>
                        <a href="{{ route('logouts') }}" class="menu-link">
                            <i class="fas fa-sign-out-alt menu-icon"></i>
                            <span>تسجيل الخروج</span>
                            <i class="fas fa-chevron-left arrow-icon"></i>
                        </a>
                    </li>
                @else
                    <!-- My Account -->
                    <li>
                        <a href="{{ route('userdashboard') }}" class="menu-link {{ request()->routeIs('userdashboard') ? 'active' : '' }}">
                            <i class="fas fa-home menu-icon"></i>
                            <span>My Account</span>
                            <i class="fas fa-chevron-right arrow-icon"></i>
                        </a>
                    </li>
                    <!-- Manage Address -->
                    <li>
                        <a href="{{ route('useraddress') }}" class="menu-link {{ request()->routeIs('useraddress') ? 'active' : '' }}">
                            <i class="fas fa-map-marked-alt menu-icon"></i>
                            <span>Manage Address</span>
                            <i class="fas fa-chevron-right arrow-icon"></i>
                        </a>
                    </li>
                    <!-- Auctions -->
                    <li>
                        <a href="{{ route('auction') }}" class="menu-link {{ request()->routeIs('auction') ? 'active' : '' }}">
                            <i class="fas fa-gavel menu-icon"></i>
                            <span>Auctions</span>
                            <i class="fas fa-chevron-right arrow-icon"></i>
                        </a>
                    </li>
                    <!-- My Products -->
                    <li>
                        <a href="{{ route('user.products') }}" class="menu-link {{ request()->routeIs('user.products') ? 'active' : '' }}">
                            <i class="fas fa-box-open menu-icon"></i>
                            <span>My Products</span>
                            <i class="fas fa-chevron-right arrow-icon"></i>
                        </a>
                    </li>
                    <!-- Logout -->
                    <li>
                        <a href="{{ route('logouts') }}" class="menu-link">
                            <i class="fas fa-sign-out-alt menu-icon"></i>
                            <span>Logout</span>
                            <i class="fas fa-chevron-right arrow-icon"></i>
                        </a>
                    </li>
                @endif
            </ul>
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

/* تحرير الملف الشخصي */
.edit-profile {
    background-color: #052C65;
    padding: 18px 20px;
    color: #fff;
}

.edit-profile span {
    display: flex;
    align-items: center;
    font-size: 15px;
}

.edit-profile i {
    font-size: 18px;
    margin-left: 12px;
}

/* القسم الرئيسي للقائمة */
.menu-section {
    padding: 15px;
}

/* رأس القائمة */
.menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 0 5px;
}

.menu-header h5 {
    margin: 0;
    font-size: 16px;
    color: #333;
    display: flex;
    align-items: center;
}

.left-icon {
    margin-left: 8px;
    color: #052C65;
}

.menu-toggle {
    background: none;
    border: none;
    color: #666;
    font-size: 18px;
    padding: 5px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.menu-toggle:hover {
    color: #052C65;
}

/* عناصر القائمة */
.menu-items {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #444;
    text-decoration: none;
    border-radius: 6px;
    margin-bottom: 5px;
    position: relative;
    transition: all 0.3s ease;
}

/* الأيقونات */
.menu-icon {
    width: 20px;
    height: 20px;
    margin-left: 12px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    transition: all 0.3s ease;
}

.arrow-icon {
    margin-right: auto;
    font-size: 12px;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
    color: #052C65;
}

/* التأثيرات */
.menu-link:hover {
    background-color: #f8f9fa;
    color: #052C65;
    padding-right: 20px;
}

.menu-link:hover .menu-icon {
    color: #052C65;
    transform: scale(1.1);
}

.menu-link:hover .arrow-icon {
    opacity: 1;
    transform: translateX(0);
}

/* حالة Active */
.menu-link.active {
    background-color: #E8F0FE;
    color: #052C65;
    font-weight: 500;
}

.menu-link.active .menu-icon {
    color: #052C65;
}

.menu-link.active .arrow-icon {
    opacity: 1;
    transform: translateX(0);
}

/* Hover Animation */
@keyframes slideRight {
    from {
        transform: translateX(-10px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.menu-items li {
    animation: slideRight 0.3s ease-out forwards;
}

.menu-items li:nth-child(1) { animation-delay: 0.1s; }
.menu-items li:nth-child(2) { animation-delay: 0.2s; }
.menu-items li:nth-child(3) { animation-delay: 0.3s; }
.menu-items li:nth-child(4) { animation-delay: 0.4s; }
.menu-items li:nth-child(5) { animation-delay: 0.5s; }

/* تحسينات للموبايل */
@media (max-width: 768px) {
    .profile-sidebar {
        margin-bottom: 20px;
    }
}


</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">