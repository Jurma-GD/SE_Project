<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Eats | Dynamic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">⚡ CampusEats</a>
            <div class="d-flex">
                <span class="badge rounded-pill bg-success">Live Updates</span>
            </div>
        </div>
    </nav>

    <div class="bg-white border-bottom py-4 mb-4">
        <div class="container text-center animate__animated animate__fadeIn">
            <h2 class="fw-800">Hungry, Student?</h2>
            <p class="text-muted">Real-time canteen updates to save you from the 'Kwago'.</p>
            
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <input type="text" class="form-control form-control-lg rounded-pill shadow-sm" placeholder="Search for Adobo, Fries, or Drinks...">
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 active">All</button>
                        <button class="btn btn-outline-dark btn-sm rounded-pill px-3">Meals</button>
                        <button class="btn btn-outline-dark btn-sm rounded-pill px-3">Snacks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>

        <div class="container mb-4">
            <div class="d-flex gap-2 overflow-x-auto pb-2">
                <button class="btn btn-dark rounded-pill px-4">All</button>
                <button class="btn btn-outline-secondary rounded-pill px-4">Silog</button>
                <button class="btn btn-outline-secondary rounded-pill px-4">Snacks</button>
                <button class="btn btn-outline-secondary rounded-pill px-4">Drinks</button>
            </div>
        </div>

        <main class="container">
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-3 vendor-card-post animate__animated animate__slideInUp">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">V</div>
                        <input type="text" class="form-control border-0 bg-light rounded-pill" placeholder="Post a menu update...">
                        <button class="btn btn-primary rounded-circle" style="width: 45px; height: 45px;">+</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="card h-100 border-0 shadow-sm menu-card-dynamic">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Food">
                        <span class="badge bg-success position-absolute top-0 end-0 m-3 shadow">Available</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-1">Tita's Kitchen</h5>
                        <p class="small text-muted mb-3">5 mins ago • Window 2</p>
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Sizzling Sisig</span>
                            <span class="fw-bold text-success">₱75.00</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>Extra Rice</span>
                            <span class="fw-bold text-success">₱12.00</span>
                        </div>
                    </div>
                </div>
            </div>

        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp">
            <div class="card h-100 border-0 shadow-sm menu-card-dynamic">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1626074353765-517a681e40be?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Tapsilog">
                    <span class="badge bg-success position-absolute top-0 end-0 m-3">Available</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Kuya's Grill</h5>
                    <p class="small text-muted mb-2">Beef Tapa + Garlic Rice + Egg</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0 text-primary fw-bold">₱95.00</span>
                        <button class="btn btn-sm btn-outline-primary rounded-pill">View Details</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp" style="animate-delay: 0.2s">
            <div class="card h-100 border-0 shadow-sm menu-card-dynamic">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Fries">
                    <span class="badge bg-success position-absolute top-0 end-0 m-3">Available</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">Potato Corner Style</h5>
                    <p class="small text-muted mb-2">Large Fries (Cheese/BBQ/Sour Cream)</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0 text-primary fw-bold">₱45.00</span>
                        <button class="btn btn-sm btn-outline-primary rounded-pill">View Details</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp" style="animate-delay: 0.4s">
            <div class="card h-100 border-0 shadow-sm menu-card-dynamic">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1626700051175-6818013e1d4f?auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Halo Halo">
                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">Sold Out</span>
                </div>
                <div class="card-body opacity-75">
                    <h5 class="card-title fw-bold">Sweet Treats</h5>
                    <p class="small text-muted mb-2">Special Halo-Halo with Ube Ice Cream</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0 text-muted fw-bold">₱65.00</span>
                        <span class="text-danger small fw-bold">Back at 1:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

</body>
</html>

<script>
body {
    font-family: 'Inter', sans-serif;
}

.fw-800 { font-weight: 800; }

/* Dynamic Hover Effects */
.menu-card-dynamic {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    overflow: hidden;
}

.menu-card-dynamic:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

/* Image Zoom on Hover */
.menu-card-dynamic img {
    transition: transform 0.5s ease;
}

.menu-card-dynamic:hover img {
    transform: scale(1.1);
}

/* Glassmorphism effect for the vendor post box */
.vendor-card-post {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Button Pulse Animation */
.btn-primary {
    transition: all 0.3s;
}

.btn-primary:hover {
    box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
    transform: scale(1.05);
}
</script>