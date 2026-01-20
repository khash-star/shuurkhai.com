<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shuurkhai - Америк барааг Монголд</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(10px); }
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        .animate-float-reverse {
            animation: floatReverse 5s ease-in-out infinite;
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-spin-slow {
            animation: spin-slow 30s linear infinite;
        }
        
        @keyframes scroll-indicator {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(12px); }
        }
        
        .animate-scroll-indicator {
            animation: scroll-indicator 2s ease-in-out infinite;
        }
        
        /* Google Translate Banner Removal - CSS Support */
        /* Hide banner iframe completely */
        iframe.goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            width: 0 !important;
            border: none !important;
            position: absolute !important;
            left: -9999px !important;
        }

        /* Lock html/body styles - prevent Google Translate from altering layout */
        html {
            top: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
            position: static !important;
        }

        body {
            top: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
            position: static !important;
        }

        /* Hide tooltips and balloons */
        .goog-te-balloon-frame,
        #goog-gt-tt,
        .goog-tooltip,
        .goog-text-highlight {
            display: none !important;
        }

        /* Ensure navbar stays at top */
        .navbar-translate {
            top: 0 !important;
        }

        /* Navbar fixed - add padding to body to prevent content overlap */
        body {
            padding-top: 70px; /* Adjust based on navbar height (reduced from 80px) */
        }
    </style>
</head>
<body class="min-h-screen bg-white">
