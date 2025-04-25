import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import './Whole.css';
import Navbar from './Navbar';
import Footer from './Footer';
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function Whole() {
    const [products, setProducts] = useState([]);
    const [searchProduct, setSearchProduct] = useState('');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [pagination, setPagination] = useState({
        currentPage: 1,
        lastPage: 1,
        total: 0,
    });
    const navigate = useNavigate();

    useEffect(() => {
        fetchProducts(); // Initial fetch
    }, []);

    const fetchProducts = async (page = 1, search = '') => {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/products?page=${page}&search=${search}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();

            console.log('API response:', data);

            setProducts(data.products || []);
            setPagination({
                currentPage: data.pagination.current_page,
                lastPage: data.pagination.last_page,
                total: data.pagination.total,
            });
        } catch (error) {
            console.error('Error fetching products:', error);
            setError('No Data Available');
            toast.error('Failed to load products.', {
                position: 'top-right',
                autoClose: 2000,
            });
        } finally {
            setLoading(false);
        }
    };

    const addProductToCart = async (product) => {
        const authToken = localStorage.getItem('authToken');
        if (!authToken) {
            toast.error('You must log in to add items to your cart.', {
                position: 'top-right',
                autoClose: 2000,
            });
            navigate('/login');
            return;
        }

        try {
            const response = await fetch('http://127.0.0.1:8000/api/cart/add', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: product.id,
                    quantity: 1,
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            toast.success('Product added to cart!', {
                position: 'top-right',
                autoClose: 2000,
            });
            navigate('/cart');
        } catch (error) {
            console.error('Error adding product to cart:', error);
            toast.error('Failed to add product to cart.', {
                position: 'top-right',
                autoClose: 3000,
            });
        }
    };

    const filteredProducts = Array.isArray(products) ? products : [];

    const handlePageChange = (page) => {
        setLoading(true);
        fetchProducts(page, searchProduct);
    };

    return (
        <div className="App">
            <Navbar />
            <ToastContainer />
            <section id="hero" className="">
                <div className="container mt-5 pt-5">
                    <div className="row align-items-center my-auto">
                        <div className="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                            <h1 className="display-5 fw-bold mb-2" style={{ color: '#09408c' }}>
                                Products of <span style={{ color: '#10526b' }}>MEDI</span>
                                <span style={{ color: '#ddb10f' }}>FAST</span>
                            </h1>
                            <p className="fw-bolder fs-4" style={{ color: '#3491ba' }}>
                                Medifast offers a range of high-quality, nutritionally balanced products designed to support weight management and healthy living.
                            </p>

                            <div className="input-group mt-4">
                                <input
                                    type="text"
                                    className="form-control bg-white text-black form-control-lg rounded-2 shadow-sm border-0"
                                    placeholder="Search for a product..."
                                    value={searchProduct}
                                    onChange={(e) => {
                                        setSearchProduct(e.target.value);
                                        fetchProducts(1, e.target.value);
                                    }}
                                />
                            </div>
                        </div>

                        <div className="col-lg-6 text-center">
                            <img
                                src="gifgit.png"
                                alt="Medicine illustration"
                                className="img-fluid rounded-4 shadow-lg"
                                style={{ maxHeight: '400px', objectFit: 'cover' }}
                            />
                        </div>
                    </div>
                </div>
            </section>
            <div className="container mt-5">
                <div className="row justify-content-center">
                    {filteredProducts.map((product, index) => (
                        <div className="col-md-6 col-lg-4 mb-4 d-flex justify-content-center" key={index}>
                            <div className="card product h-100 shadow-sm border rounded-3 overflow-hidden">
                                <img
                                    src={`http://127.0.0.1:8000/${product.image}`}
                                    className="card-img-top"
                                    alt={product.name || 'Product'}
                                    onError={(e) => (e.target.src = '/placeholder.png')}
                                />
                                <div
                                    className="card-body text-white d-flex flex-column justify-content-between"
                                    style={{ background: '#096577' }}
                                >
                                    <div>
                                        <h5 className="card-title fw-bold">{product.name || 'Unknown Product'}</h5>
                                        <p className="card-text">{product.description || 'No description available'}</p>
                                    </div>
                                    <div className="d-flex align-items-center justify-content-between">
                                        <div className="col-6">
                                            <p className="card-text fw-bold mt-3">
                                                Price: {product.price || 'N/A'} RS
                                            </p>
                                        </div>
                                        <div className="col-6 d-flex justify-content-end">
                                            <button
                                                onClick={() => addProductToCart(product)}
                                                className="text-white btn text-capitalize"
                                                style={{ background: '#063444' }}
                                            >
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                    {filteredProducts.length === 0 && !loading && (
                        <div className="text-center text-muted fs-4 fw-bold mt-5 mb-5">No Products Found</div>
                    )}
                </div>

                {/* PAGINATION */}
                <div className="pagination">
                    {pagination.currentPage > 1 && (
                        <button onClick={() => handlePageChange(pagination.currentPage - 1)}>Previous</button>
                    )}
                    {[...Array(pagination.lastPage)].map((_, index) => (
                        <button
                            key={index}
                            onClick={() => handlePageChange(index + 1)}
                            className={pagination.currentPage === index + 1 ? 'active' : ''}
                        >
                            {index + 1}
                        </button>
                    ))}
                    {pagination.currentPage < pagination.lastPage && (
                        <button onClick={() => handlePageChange(pagination.currentPage + 1)}>Next</button>
                    )}
                </div>
            </div>
            <Footer />
        </div>
    );
}

export default Whole;
