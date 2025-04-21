import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Navbar from '../Navbar';
import Footer from '../Footer';
import { toast } from 'react-toastify';

const Checkout = () => {
    const [cartProducts, setCartProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [formData, setFormData] = useState({
        name: '',
        phone: '',
        address: '',
    });
    const navigate = useNavigate();
    // Redirect if authToken is not available
    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (!authToken) {
            toast.error('You must log in to proceed with checkout.', {
                toastId: 'login-error',
                position: 'top-right',
                autoClose: 3000,
            });
            navigate('/login');
        }
    }, [navigate]);

    const fetchCart = async () => {
        setLoading(true);
        setError(null);
        try {
            const response = await fetch('http://127.0.0.1:8000/api/cart', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Cart API response:', data);
            setCartProducts(data.carts || []);
        } catch (error) {
            console.error('Error fetching cart:', error);
            setError('Failed to load cart. Please try again later.');
            toast.error('Failed to load cart.', {
                toastId: 'fetch-error',
                position: 'top-right',
                autoClose: 3000,
            });
        } finally {
            setLoading(false);
        }
    };

    const calculateTotalPrice = () => {
        return cartProducts.reduce((sum, item) => sum + item.product.price * item.quantity, 0).toFixed(2);
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (name === 'phone') {
            let cleanedValue = value.replace(/[^+\d]/g, '');
            if (!cleanedValue.startsWith('+92')) {
                cleanedValue = '+92' + cleanedValue.replace(/^\+92/, '');
            }
            if (cleanedValue.length > 13) {
                cleanedValue = cleanedValue.slice(0, 13);
            }
            setFormData((prev) => ({ ...prev, phone: cleanedValue }));
        } else {
            setFormData((prev) => ({ ...prev, [name]: value }));
        }
    };

    const validatePhoneNumber = (phone) => {
        const regex = /^\+92\d{10}$/;
        return regex.test(phone);
    };

    const handleConfirmCheckout = async (e) => {
        e.preventDefault();
        if (!formData.name || !formData.phone || !formData.address) {
            toast.error('Please fill in all fields.', {
                toastId: 'form-error',
                position: 'top-right',
                autoClose: 3000,
            });
            return;
        }
        if (!validatePhoneNumber(formData.phone)) {
            toast.error('Please enter a valid Pakistani phone number (+92 followed by 10 digits).', {
                toastId: 'phone-error',
                position: 'top-right',
                autoClose: 3000,
            });
            return;
        }
        try {
            const response = await fetch('http://127.0.0.1:8000/api/checkout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: formData.name,
                    phone: formData.phone,
                    address: formData.address,
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            toast.success('Order placed successfully!', {
                toastId: 'checkout-success',
                position: 'top-right',
                autoClose: 2000,
            });
            localStorage.setItem('count',"0");
            navigate('/'); // Adjust route as needed
        } catch (error) {
            console.error('Error during checkout:', error);
            toast.error('Failed to place order. Please try again.', {
                toastId: 'checkout-fail',
                position: 'top-right',
                autoClose: 3000,
            });
        }
    };

    const handleReturnToCart = () => {
        navigate('/cart');
    };

    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (authToken) {
            fetchCart();
        }
    }, []);

    return (
        <div className="min-h-screen flex flex-col">
            <Navbar />
            <div
                className="flex-grow p-4"
                style={{
                    backgroundImage: 'url("./loginbackground.jpg")',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    minHeight: '90vh',
                }}
            >
                <h2 className="text-2xl font-bold my-5 pt-5 text-center text-white">Checkout</h2>
                {loading ? (
                    <p className="text-white text-center">Loading cart...</p>
                ) : error ? (
                    <p className="text-red-500 text-center">{error}</p>
                ) : (
                    <div className="d-md-flex justify-content-evenly align-items-center">
                        {/* Cart Items Table */}
                        <div className="col-lg-5 m-2">
                            <div className="overflow-x-auto d-flex justify-content-center">
                                <table className="w-full shadow-md rounded-1" style={{ backgroundColor: 'rgba(255, 255, 255, 0.7)' }}>
                                    <thead>
                                    <tr className="bg-gray-200 text-gray-700">
                                        <th className="py-3 px-4 text-left">Image</th>
                                        <th className="py-3 px-4 text-left">Name</th>
                                        <th className="py-3 px-4 text-left">Quantity</th>
                                        <th className="py-3 px-4 text-left">Gross Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {cartProducts.length === 0 ? (
                                        <tr>
                                            <td colSpan="4" className="py-4 px-4 text-center text-gray-500">
                                                No items in cart
                                            </td>
                                        </tr>
                                    ) : (
                                        cartProducts.map((cartItem) => (
                                            <tr key={cartItem.id} className="border-b">
                                                <td className="py-3 px-4">
                                                    <img style={{height:"60px",width:"80px"}}
                                                        src={`http://127.0.0.1:8000/${cartItem.product.image}`}
                                                        alt={cartItem.product.name || 'Product'}
                                                        className="w-16 h-16 object-cover rounded"
                                                    />
                                                </td>
                                                <td className="py-3 px-4">{cartItem.product.name || 'Unknown Product'}</td>
                                                <td className="py-3 px-4">{cartItem.quantity || 1}</td>
                                                <td className="py-3 px-4">
                                                    RS {(cartItem.product.price * cartItem.quantity).toFixed(2) || 'N/A'}
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                    </tbody>
                                    <tfoot>
                                    {cartProducts.length > 0 && (
                                        <tr className="bg-gray-100 font-bold">
                                            <td colSpan="3" className="py-3 px-4 text-right">
                                                Total:
                                            </td>
                                            <td className="py-3 px-4">
                                                RS {calculateTotalPrice()}
                                            </td>
                                        </tr>
                                    )}
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {/* Checkout Form */}
                        <div className="col-lg-5">
                            <form onSubmit={handleConfirmCheckout} className="bg-white bg-opacity-70 p-5 rounded-1 m-2 shadow-md">
                                <h3 className="text-xl font-semibold mb-4 text-black">Customer Information</h3>
                                <div className="mb-4">
                                    <label className="block text-gray-700 font-medium mb-2" htmlFor="name">
                                        Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value={formData.name}
                                        onChange={handleInputChange}
                                        placeholder="Enter your name"
                                        className="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-gray-700 font-medium mb-2" htmlFor="phone" style={{display:"block"}}>
                                        Phone Number
                                    </label>
                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        value={formData.phone}
                                        onChange={handleInputChange}
                                        placeholder="Enter your phone number"
                                        className="w-100 border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-gray-700 font-medium mb-2" htmlFor="address">
                                        Address
                                    </label>
                                    <input
                                        type="text"
                                        id="address"
                                        name="address"
                                        value={formData.address}
                                        onChange={handleInputChange}
                                        placeholder="Enter your address"
                                        className="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div className="flex justify-between">
                                    <button
                                        type="submit"
                                        className="bg-success text-white px-4 py-2 rounded"
                                    >
                                        Confirm Checkout
                                    </button>
                                    <button
                                        type="button"
                                        onClick={handleReturnToCart}
                                        className="bg-danger mx-4 text-white px-4 py-2 rounded"
                                    >
                                        Return to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
            <Footer />
        </div>
    );
};

export default Checkout;
