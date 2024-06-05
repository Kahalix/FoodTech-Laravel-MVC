<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPro Insight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        nav {
            background-color: #444;
        }
        .navbar-nav .nav-link {
            color: #fff;
            padding: 10px 20px;
        }
        .navbar-nav .nav-link:hover, .navbar-nav .active-link {
            background-color: #555;
        }
        section {
            display: none;
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        section.active {
            display: block;
            opacity: 1;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>NutriPro Insight</h1>
</header>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" height="50px" alt="logo">NutriPro Insight</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#dashboard">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <section id="home" class="active">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h2 class="display-5 fw-bold">Welcome to NutriPro Insight</h2>
                <p class="col-md-8 fs-4">We are a leading food technology company specializing in the analysis and testing of products for various companies. Our mission is to ensure the highest standards of quality and safety in food production.</p>
            </div>
        </div>
        <div id="statistics" class="mt-5">
            <h3>Our Statistics And Tests</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Collaborating Companies</h5>
                            <p class="card-text" id="company-count">0</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Completed Orders</h5>
                            <p class="card-text" id="order-count">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Random Test Results</h5>
                        <div class="row mt-5" id="random-test-results"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Completed Orders Per Month</h5>
                        <canvas id="ordersChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <h2>About Us</h2>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <p class="card-text">NutriPro Insight is committed to advancing food safety and quality. With our state-of-the-art laboratories and expert team, we offer comprehensive testing services that ensure the products you consume meet the highest standards. We partner with companies to test their products, providing detailed reports and actionable insights.</p>
                <p>Our achievements include:</p>
                <ul>
                    <li>Over 10 years of experience in food technology</li>
                    <li>Collaborations with big and small companies</li>
                    <li>Wide range of products tested</li>
                    <li>Highly skilled testers</li>
                    <li>Over 99% customer satisfaction</li>
                    <li>Innovative testing methodologies</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="services">
        <h2>Our Services</h2>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <p class="card-text">At NutriPro Insight, we offer a range of services to meet the diverse needs of our clients:</p>
                <ul>
                    <li>Microbiological Testing</li>
                    <li>Chemical Analysis</li>
                    <li>Nutritional Analysis</li>
                    <li>Sensory Evaluation</li>
                    <li>Consulting and Advisory Services</li>
                </ul>
                <p>We use cutting-edge technology and adhere to international standards to provide reliable and accurate results.</p>
            </div>
        </div>
    </section>

    <section id="contact">
        <h2>Contact Us</h2>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <p class="card-text">We would love to hear from you! If you have any questions or would like to learn more about our services, please get in touch with us:</p>
                <address>
                    <strong>NutriPro Insight</strong><br>
                    123 Food Tech Street<br>
                    Food City, FC 12345<br>
                    Phone: (123) 456-7890<br>
                    Email: <a href="mailto:info@nutriproinsight.com">info@nutriproinsight.com</a>
                </address>
                <p>Follow us on social media for the latest updates and industry news:</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#" class="btn btn-primary btn-sm">Facebook</a></li>
                    <li class="list-inline-item"><a href="#" class="btn btn-info btn-sm">Twitter</a></li>
                    <li class="list-inline-item"><a href="#" class="btn btn-primary btn-sm">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section id="dashboard">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header">User Dashboard</div>
                    <div class="card-body">
                        <h5 class="card-title">Dashboard for Users</h5>
                        <p class="card-text">Access your user-specific dashboard here.</p>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Go to User Dashboard</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success mb-3">
                    <div class="card-header">Company Dashboard</div>
                    <div class="card-body">
                        <h5 class="card-title">Dashboard for Companies</h5>
                        <p class="card-text">Access your company-specific dashboard here.</p>
                        <a href="{{ route('company.dashboard') }}" class="btn btn-success">Go to Company Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchStatistics();
    });

    function fetchStatistics() {
        fetch('/api/statistics')
            .then(response => response.json())
            .then(data => {
                document.getElementById('company-count').textContent = data.companyCount;
                document.getElementById('order-count').textContent = data.completedOrdersCount;
                const resultsList = document.getElementById('random-test-results');
                data.randomTestResults.forEach(result => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item', 'mb-4');
                    const card = document.createElement('div');
                    card.classList.add('card');

                    const cardBody = document.createElement('div');
                    cardBody.classList.add('card-body');

                    const text = document.createElement('p');
                    text.textContent = `${result.test_results}`;
                    const decision = document.createElement('p');
                    decision.textContent = `Decision: ${result.decision}`;

                    const row = document.createElement('div');
                    row.classList.add('row', 'g-3', 'mt-3');

                    result.images.forEach(imagePath => {
                        const col = document.createElement('div');
                        col.classList.add('col-md-4');
                        const image = document.createElement('img');
                        image.src = imagePath;
                        image.style.width = '300px';
                        image.alt = 'result image';
                        image.classList.add('img-fluid');
                        col.appendChild(image);
                        row.appendChild(col);
                    });

                    cardBody.appendChild(text);
                    cardBody.appendChild(decision);
                    cardBody.appendChild(row);
                    card.appendChild(cardBody);
                    listItem.appendChild(card);
                    resultsList.appendChild(listItem);
                });

                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const ordersPerMonth = new Array(12).fill(0);
                for (const [month, count] of Object.entries(data.completedOrdersPerMonth)) {
                    ordersPerMonth[parseInt(month) - 1] = count;
                }

                const ctx = document.getElementById('ordersChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Completed Orders',
                            data: ordersPerMonth,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    }

    document.querySelectorAll('nav .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('section').forEach(section => section.classList.remove('active'));
            document.querySelector(link.getAttribute('href')).classList.add('active');
        });
    });
</script>

</body>
</html>
