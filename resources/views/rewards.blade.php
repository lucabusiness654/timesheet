<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards & Recognition</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #e63946;
            --secondary: #d90429;
            --accent: #ef233c;
            --light: #f8f9fa;
            --dark: #212529;
            --black: #000000;
            --white: #ffffff;
            --success: #2a9d8f;
            --warning: #f4a261;
            --danger: #e76f51;
            --timeline-width: 4px;
            --card-width: 320px;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--dark);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Background elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .bg-element {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(230, 57, 70, 0.1) 0%, rgba(230, 57, 70, 0) 70%);
            z-index: -1;
            animation: float 15s ease-in-out infinite;
        }

        .bg-element-1 {
            top: 10%;
            left: 5%;
            width: 300px;
            height: 300px;
            animation-delay: 0s;
        }

        .bg-element-2 {
            bottom: 15%;
            right: 8%;
            width: 250px;
            height: 250px;
            animation-delay: 2s;
            animation-direction: reverse;
        }

        .bg-element-3 {
            top: 50%;
            left: 30%;
            width: 180px;
            height: 180px;
            animation-delay: 4s;
        }

        .bg-element-4 {
            top: 20%;
            right: 20%;
            width: 200px;
            height: 200px;
            animation-delay: 6s;
            animation-direction: reverse;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 10;
        }

        .header-content {
            display: inline-block;
            position: relative;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--primary), var(--danger));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .team-badge {
            display: inline-flex;
            align-items: center;
            background: var(--black);
            color: var(--white);
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: fadeInDown 0.8s ease-out;
        }

        .team-badge i {
            color: #ff2d20;
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        /* Timeline */
        .timeline-container {
            position: relative;
            padding: 3rem 0;
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: var(--timeline-width);
            background: linear-gradient(to bottom, var(--primary), var(--danger));
            transform: translateX(-50%);
            z-index: 1;
            border-radius: 10px;
        }

        .timeline-items {
            display: flex;
            flex-direction: column;
            gap: 4rem;
            position: relative;
            z-index: 2;
        }

        .timeline-month {
            position: relative;
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            animation: fadeIn 0.8s ease-out;
        }

        .month-label {
            background: var(--primary);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.3);
            position: relative;
            z-index: 3;
            animation: pulse 2s infinite;
        }

        .timeline-month-group {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .timeline-item {
            display: flex;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .timeline-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .timeline-item:nth-child(odd) {
            justify-content: flex-start;
            padding-right: calc(50% + 2rem);
        }

        .timeline-item:nth-child(even) {
            justify-content: flex-end;
            padding-left: calc(50% + 2rem);
        }

        .reward-card {
            width: var(--card-width);
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            position: relative;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .reward-card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(230, 57, 70, 0.15);
            border-color: rgba(230, 57, 70, 0.2);
        }

        .reward-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--danger));
        }

        .reward-point {
            position: absolute;
            top: 50%;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--white);
            border: 4px solid var(--primary);
            transform: translateY(-50%);
            z-index: 3;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 0.7rem;
        }

        .timeline-item:nth-child(odd) .reward-point {
            right: calc(50% - 12px - var(--timeline-width)/2);
        }

        .timeline-item:nth-child(even) .reward-point {
            left: calc(50% - 12px - var(--timeline-width)/2);
        }

        .reward-card:hover .reward-point {
            transform: translateY(-50%) scale(1.2);
            box-shadow: 0 0 0 6px rgba(230, 57, 70, 0.2);
            background: var(--primary);
            border-color: var(--white);
            color: var(--white);
        }

        .reward-content {
            padding: 1.5rem;
        }

        .reward-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .reward-badge {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
            margin-right: 1rem;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--danger));
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.3);
            transition: var(--transition);
        }

        .reward-card:hover .reward-badge {
            transform: rotate(15deg) scale(1.1);
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.4);
        }

        .reward-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }

        .reward-date {
            font-size: 0.8rem;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .reward-date i {
            margin-right: 5px;
            font-size: 0.7rem;
            color: var(--primary);
        }

        .reward-employee {
            display: flex;
            align-items: center;
            padding: 0.8rem;
            background: rgba(248, 249, 250, 0.7);
            border-radius: 12px;
            margin-top: 1rem;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .reward-employee:hover {
            background: rgba(230, 57, 70, 0.1);
            transform: translateX(5px);
            border-color: rgba(230, 57, 70, 0.2);
        }

        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--danger));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.8rem;
            flex-shrink: 0;
        }

        .employee-details {
            flex: 1;
        }

        .employee-name {
            font-weight: 600;
            margin-bottom: 0.2rem;
            color: var(--dark);
        }

        .employee-meta {
            font-size: 0.75rem;
            color: #6c757d;
            display: flex;
            gap: 0.8rem;
        }

        .employee-meta span {
            display: flex;
            align-items: center;
        }

        .employee-meta i {
            font-size: 0.6rem;
            margin-right: 3px;
            color: var(--primary);
        }

        .reward-id {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--primary);
            background: rgba(230, 57, 70, 0.1);
            padding: 3px 8px;
            border-radius: 20px;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .modal.active {
            opacity: 1;
            pointer-events: all;
        }

        .modal-content {
            background: var(--white);
            border-radius: 20px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal-banner {
            width: 100%;
            height: 450px;
            object-fit: cover;
            display: block;
            border-bottom: 5px solid var(--primary);
            opacity: 0;
            transition: opacity 0.6s ease 0.2s;
        }

        .modal.active .modal-banner {
            opacity: 1;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            cursor: pointer;
            transition: var(--transition);
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-close:hover {
            background: var(--primary);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2.5rem;
            position: relative;
        }

        .modal-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            background: linear-gradient(90deg, var(--primary), var(--danger));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease 0.3s;
        }

        .modal.active .modal-title {
            opacity: 1;
            transform: translateY(0);
        }

        .modal-description {
            color: #6c757d;
            line-height: 1.8;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease 0.4s;
        }

        .modal.active .modal-description {
            opacity: 1;
            transform: translateY(0);
        }

        .modal-employee {
            display: flex;
            align-items: center;
            background: rgba(248, 249, 250, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease 0.5s;
        }

        .modal.active .modal-employee {
            opacity: 1;
            transform: translateY(0);
        }

        .modal-employee:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            background: rgba(230, 57, 70, 0.05);
            border-color: rgba(230, 57, 70, 0.2);
        }

        .modal-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--danger));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            margin-right: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.3);
        }

        .modal-employee-details {
            flex: 1;
        }

        .modal-employee-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .modal-employee-id {
            font-size: 0.9rem;
            color: var(--primary);
            margin-bottom: 0.8rem;
            display: inline-block;
            background: rgba(230, 57, 70, 0.1);
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .modal-employee-meta {
            display: flex;
            gap: 1.5rem;
        }

        .modal-meta-item {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .modal-meta-item i {
            margin-right: 8px;
            color: var(--primary);
            font-size: 1rem;
        }

        /* No results */
        .no-results {
            text-align: center;
            padding: 5rem 2rem;
            grid-column: 1 / -1;
        }

        .no-results i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .no-results h3 {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .no-results p {
            color: #adb5bd;
        }

        /* Loading */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .loading-dot {
            width: 15px;
            height: 15px;
            margin: 0 8px;
            background-color: var(--primary);
            border-radius: 50%;
            animation: loading-bounce 0.8s infinite alternate;
        }

        .loading-dot:nth-child(2) {
            animation-delay: 0.2s;
            background-color: var(--danger);
        }

        .loading-dot:nth-child(3) {
            animation-delay: 0.4s;
            background-color: var(--black);
        }

        /* Confetti */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            opacity: 0;
            animation: confetti-fall 3s linear forwards;
            z-index: 9999;
        }

        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(0) translateX(20px);
            }
            75% {
                transform: translateY(-10px) translateX(-10px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(230, 57, 70, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(230, 57, 70, 0);
            }
        }

        @keyframes loading-bounce {
            to {
                transform: translateY(-25px);
                opacity: 0.5;
            }
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .timeline-item:nth-child(odd),
            .timeline-item:nth-child(even) {
                justify-content: center;
                padding: 0;
            }

            .timeline-item:nth-child(odd) .reward-point,
            .timeline-item:nth-child(even) .reward-point {
                display: none;
            }

            .timeline-line {
                left: 40px;
            }

            .timeline-items {
                padding-left: 60px;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }

            .timeline-line {
                left: 30px;
            }

            .timeline-items {
                padding-left: 40px;
            }

            .reward-card {
                width: 100%;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .modal-banner {
                height: 350px;
            }

            .modal-employee {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem 1rem;
            }

            .modal-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
                width: 70px;
                height: 70px;
                font-size: 1.5rem;
            }

            .modal-employee-meta {
                flex-direction: column;
                gap: 0.5rem;
                margin-top: 0.8rem;
            }

            .modal-title {
                font-size: 1.6rem;
            }

            .modal-description {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 1.5rem;
            }

            header {
                margin-bottom: 2rem;
            }

            .team-badge {
                font-size: 0.9rem;
                padding: 0.4rem 1rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            .timeline-line {
                left: 20px;
            }

            .timeline-items {
                padding-left: 30px;
            }

            .modal-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>
    <!-- Background elements -->
    <div class="bg-elements">
        <div class="bg-element bg-element-1"></div>
        <div class="bg-element bg-element-2"></div>
        <div class="bg-element bg-element-3"></div>
        <div class="bg-element bg-element-4"></div>
    </div>

    <div class="container">
        <header>
            <div class="header-content">
                <div class="team-badge">
                    <i class="fab fa-laravel"></i>
                    Prasanna Back End Team
                </div>
                <h1 class="animate__animated animate__fadeInUp">Rewards & Recognition</h1>
                <p class="subtitle">Celebrating outstanding achievements and contributions of our team members</p>
            </div>
        </header>

        <div class="timeline-container">
            <div class="timeline-line"></div>
            <div class="timeline-items" id="timeline-items">
                <!-- Timeline items will be loaded here -->
                <div class="loading">
                    <div class="loading-dot"></div>
                    <div class="loading-dot"></div>
                    <div class="loading-dot"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="reward-modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <img src="" alt="Reward Banner" class="modal-banner" id="modal-banner">
            <div class="modal-body">
                <h2 class="modal-title" id="modal-title"></h2>
                <p class="modal-description" id="modal-description"></p>
                <div class="modal-employee" id="modal-employee">
                    <div class="modal-avatar" id="modal-avatar"></div>
                    <div class="modal-employee-details">
                        <h3 class="modal-employee-name" id="modal-employee-name"></h3>
                        <span class="modal-employee-id" id="modal-employee-id"></span>
                        <div class="modal-employee-meta">
                            <div class="modal-meta-item">
                                <i class="fas fa-building"></i>
                                <span id="modal-department"></span>
                            </div>
                            <div class="modal-meta-item">
                                <i class="fas fa-briefcase"></i>
                                <span id="modal-position"></span>
                            </div>
                            <div class="modal-meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span id="modal-date"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Sample data for rewards with multiple entries per month
        const rewardsData = [
            {
                id: "Y24-EOM-001",
                name: "Employee of the Month",
                description: "Awarded for exceptional performance, dedication, and contribution throughout the past three month.",
                logo: "🏆",
                banner: "https://source.unsplash.com/random/1600x900/?award,trophy,red",
                date: "2024-06-21",
                employee: {
                    name: "Raviteja",
                    empId: "SW-995",
                    department: "Backend",
                    position: "Software Developer",
                    avatar: "R"
                }
            },
            {
                id: "Y24-PRF-001",
                name: "Performance Excellence",
                description: "Recognized for outstanding performance in third party.",
                logo: "🚀",
                banner: "https://ik.imagekit.io/dluolosrh/sneha-y24-08.jpg",
                date: "2024-12-08",
                employee: {
                    name: "Sneha C R",
                    empId: "SW-423",
                    department: "Backend",
                    position: "Software Developer",
                    avatar: "SCR"
                }
            },
            {
                id: "Y25-RRS-001",
                name: "Release Rock Star",
                description: "Recognized for outstanding performance in sale logic, hard work, and dedication",
                logo: "💡",
                banner: "https://ik.imagekit.io/dluolosrh/franklin-y25-03.jpg",
                date: "2025-04-21",
                employee: {
                    name: "Habidas Franklin",
                    empId: "SW-1474",
                    department: "Backend",
                    position: "Sr.Software Developer",
                    avatar: "HF"
                }
            },
            {
                id: "Y25-QCA-001",
                name: "Quality Champion",
                description: "Recognized for maintaining code quality standards",
                logo: "🌟",
                banner: "https://ik.imagekit.io/dluolosrh/raviteja-y25-03%20(1)%20(1).jpg",
                date: "2025-04-21",
                employee: {
                    name: "Raviteja",
                    empId: "SW-995",
                    department: "Backend",
                    position: "Sr.Software Developer",
                    avatar: "R"
                }
            },
            {
                id: "Y25-CIN-001",
                name: "Code Innovator",
                description: "Recognition of your hard work, creativity, and dedication to your tasks",
                logo: "🛠️",
                banner: "https://ik.imagekit.io/dluolosrh/manish-y25-03%20(1).jpg",
                date: "2025-04-21",
                employee: {
                    name: "Manish",
                    empId: "SW-1056",
                    department: "Backend",
                    position: "Sr.Software Developer",
                    avatar: "M"
                }
            }
        ];

        // DOM elements
        const timelineItems = document.getElementById('timeline-items');
        const modal = document.getElementById('reward-modal');
        const modalBanner = document.getElementById('modal-banner');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const modalEmployee = document.getElementById('modal-employee');
        const modalAvatar = document.getElementById('modal-avatar');
        const modalEmployeeName = document.getElementById('modal-employee-name');
        const modalEmployeeId = document.getElementById('modal-employee-id');
        const modalDepartment = document.getElementById('modal-department');
        const modalPosition = document.getElementById('modal-position');
        const modalDate = document.getElementById('modal-date');
        const modalClose = document.querySelector('.modal-close');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function () {
            if (!timelineItems) return;

            // Load rewards
            renderTimeline(rewardsData);

            // Simulate loading data
            setTimeout(() => {
                const loadingElement = document.querySelector('.loading');
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }
                animateTimelineItems();
            }, 1500);
        });

        // Group rewards by month
        function groupRewardsByMonth(rewards) {
            const grouped = {};

            rewards.forEach(reward => {
                const date = new Date(reward.date);
                const monthYear = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long'
                });

                if (!grouped[monthYear]) {
                    grouped[monthYear] = [];
                }

                grouped[monthYear].push(reward);
            });

            return grouped;
        }

        // Render timeline with rewards grouped by month
        function renderTimeline(rewards) {
            if (!timelineItems) return;

            timelineItems.innerHTML = '';

            if (!rewards || rewards.length === 0) {
                timelineItems.innerHTML = `
                    <div class="no-results">
                        <i class="far fa-trophy-alt"></i>
                        <h3>No rewards found</h3>
                        <p>There are no rewards to display at this time</p>
                    </div>
                `;
                return;
            }

            // Sort rewards by date (newest first)
            rewards.sort((a, b) => new Date(b.date) - new Date(a.date));

            // Group rewards by month
            const groupedRewards = groupRewardsByMonth(rewards);

            // Create timeline items for each month
            Object.keys(groupedRewards).forEach(monthYear => {
                const monthRewards = groupedRewards[monthYear];

                // Create month label
                const monthLabel = document.createElement('div');
                monthLabel.className = 'timeline-month';
                monthLabel.innerHTML = `
                    <div class="month-label">${monthYear}</div>
                `;
                timelineItems.appendChild(monthLabel);

                // Create container for month's rewards
                const monthGroup = document.createElement('div');
                monthGroup.className = 'timeline-month-group';

                // Add each reward for the month
                monthRewards.forEach((reward, index) => {
                    const timelineItem = document.createElement('div');
                    timelineItem.className = 'timeline-item';

                    // Format date
                    const dateObj = new Date(reward.date);
                    const formattedDate = dateObj.toLocaleDateString('en-US', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });

                    // Alternate card positions (left/right)
                    const isOdd = index % 2 === 0;

                    timelineItem.innerHTML = `
                        <div class="reward-card">
                            <span class="reward-id">${reward.id}</span>
                            <div class="reward-content">
                                <div class="reward-header">
                                    <div class="reward-badge">${reward.logo}</div>
                                    <div>
                                        <h3 class="reward-title">${reward.name}</h3>
                                        <div class="reward-date">
                                            <i class="far fa-calendar"></i>
                                            ${formattedDate}
                                        </div>
                                    </div>
                                </div>
                                <div class="reward-employee">
                                    <div class="employee-avatar">${reward.employee.avatar}</div>
                                    <div class="employee-details">
                                        <div class="employee-name">${reward.employee.name}</div>
                                        <div class="employee-meta">
                                            <span><i class="fas fa-building"></i> ${reward.employee.department}</span>
                                            <span><i class="fas fa-briefcase"></i> ${reward.employee.position}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reward-point">
                            <i class="fas fa-award"></i>
                        </div>
                    `;

                    // Add appropriate class based on position
                    if (isOdd) {
                        timelineItem.classList.add('odd-position');
                    } else {
                        timelineItem.classList.add('even-position');
                    }

                    monthGroup.appendChild(timelineItem);

                    // Add click event to reward card
                    const card = timelineItem.querySelector('.reward-card');
                    if (card) {
                        card.addEventListener('click', function () {
                            resetModalContent();
                            openModal(reward);
                            createConfetti();
                        });
                    }
                });

                timelineItems.appendChild(monthGroup);
            });
        }

        // Reset modal content before showing new content
        function resetModalContent() {
            if (modalBanner) modalBanner.src = '';
            if (modalTitle) modalTitle.textContent = '';
            if (modalDescription) modalDescription.textContent = '';
            if (modalAvatar) modalAvatar.textContent = '';
            if (modalEmployeeName) modalEmployeeName.textContent = '';
            if (modalEmployeeId) modalEmployeeId.textContent = '';
            if (modalDepartment) modalDepartment.textContent = '';
            if (modalPosition) modalPosition.textContent = '';
            if (modalDate) modalDate.textContent = '';
        }

      // Open modal with reward details
    function openModal(reward) {
        if (!modal || !reward) return;

        // Format date for modal
        const dateObj = new Date(reward.date);
        const formattedDate = dateObj.toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        // Set modal content
        if (modalBanner) modalBanner.src = reward.banner;
        if (modalTitle) modalTitle.textContent = reward.name;
        if (modalDescription) modalDescription.textContent = reward.description;
        if (modalAvatar) modalAvatar.textContent = reward.employee.avatar;
        if (modalEmployeeName) modalEmployeeName.textContent = reward.employee.name;
        if (modalEmployeeId) modalEmployeeId.textContent = reward.employee.empId;
        if (modalDepartment) modalDepartment.textContent = reward.employee.department;
        if (modalPosition) modalPosition.textContent = reward.employee.position;
        if (modalDate) modalDate.textContent = formattedDate;

        // Show modal
        modal.classList.add('active');

        // Close modal when clicking outside content
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    }

    // Close modal
    function closeModal() {
        if (modal) {
            modal.classList.remove('active');
        }
    }

    // Animate timeline items as they come into view
    function animateTimelineItems() {
        const items = document.querySelectorAll('.timeline-item');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        items.forEach(item => {
            observer.observe(item);
        });
    }

    // Create confetti effect
    function createConfetti() {
        const colors = ['#e63946', '#f4a261', '#2a9d8f', '#264653', '#e9c46a'];
        
        for (let i = 0; i < 100; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
            confetti.style.animationDelay = (Math.random() * 2) + 's';
            document.body.appendChild(confetti);

            // Remove confetti after animation completes
            setTimeout(() => {
                confetti.remove();
            }, 5000);
        }
    }

    // Close modal when clicking close button
    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }
</script>
</body> </html>


