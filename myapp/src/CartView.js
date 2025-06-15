import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Navbar from './Navbar';
import Footer from './Footer';
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const CartView = () => {
    const [cartProducts, setCartProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    // Redirect if authToken is not available
    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (!authToken) {
            toast.error('You must log in to access your cart.', {
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
            if (data.response.cart_count !== undefined) {
                localStorage.setItem('count', data.cart_count);
            } else {
                console.warn('cart_count missing in API response');
            }
            setCartProducts(data.carts || []);
        } catch (error) {
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

    const updateQuantity = async (cartId, quantity) => {
        const parsedQuantity = parseInt(quantity, 10);
        if (isNaN(parsedQuantity) || parsedQuantity < 1) {
            toast.error('Please enter a valid quantity.', {
                toastId: 'quantity-error',
                position: 'top-right',
                autoClose: 3000,
            });
            return;
        }

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/cart/${cartId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity: parsedQuantity }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            await fetchCart();
            toast.success('Quantity updated successfully.', {
                toastId: 'quantity-success',
                position: 'top-right',
                autoClose: 2000,
            });
        } catch (error) {
            console.error('Error updating quantity:', error);
            toast.error('Failed to update quantity.', {
                toastId: 'quantity-fail',
                position: 'top-right',
                autoClose: 3000,
            });
        }
    };
    const calculateGrandTotal = () => {
        return cartProducts.reduce((sum, item) => sum + item.product.price * item.quantity, 0).toFixed(2);
    };
    const handleCheckout = () => {
        navigate('/checkout');
    };
    const deleteProductFromCart = async (cartId) => {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            await fetchCart();
            toast.success('Product removed from cart.', {
                toastId: 'delete-success',
                position: 'top-right',
                autoClose: 2000,
            });
        } catch (error) {
            console.error('Error deleting from cart:', error);
            toast.error('Failed to remove product.', {
                toastId: 'delete-fail',
                position: 'top-right',
                autoClose: 3000,
            });
        }
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
                <h2 className="text-2xl font-bold my-5 pt-5 text-center text-white">Your Cart</h2>
                {loading ? (
                    <p className="text-white text-center">Loading cart...</p>
                ) : error ? (
                    <p className="text-red-500 text-center">{error}</p>
                ) : (
                    <div className="overflow-x-auto d-flex justify-content-center">
                        <table className="w-full shadow-md rounded-lg" style={{ backgroundColor: 'rgba(255, 255, 255,0.9)' }}>
                            <thead>
                            <tr className="bg-gray-200 text-gray-700">
                                <th className="py-3 px-4 text-left">Image</th>
                                <th className="py-3 px-4 text-left">Product Name</th>
                                <th className="py-3 px-4 text-left">Unit Price</th>
                                <th className="py-3 px-4 text-left">Quantity</th>
                                <th className="py-3 px-4 text-left">Total</th>
                                <th className="py-3 px-4 text-left">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            {cartProducts.length === 0 ? (
                                <tr>
                                    <td colSpan="6" className="py-4 px-4 text-center text-gray-500">
                                        No data available
                                    </td>
                                </tr>
                            ) : (
                                cartProducts.map((cartItem) => (
                                    <tr key={cartItem.id} className="border-b">
                                        <td className="py-3 px-4">
                                            <img
                                                src={`http://127.0.0.1:8000/${cartItem.product.image}`} style={{height:"60px",width:"80px"}}
                                                alt={cartItem.product.name || 'Product'}
                                                className="w-16 h-16 object-cover rounded"
                                            />
                                        </td>
                                        <td className="py-3 px-4">{cartItem.product.name || 'Unknown Product'}</td>
                                        <td className="py-3 px-4">RS {cartItem.product.price || 'N/A'}</td>
                                        <td className="py-3 px-4">
                                            <input
                                                type="number"
                                                min="1"
                                                value={cartItem.quantity || 1}
                                                onChange={(e) => updateQuantity(cartItem.id, e.target.value)}
                                                className="w-16 border px-2 py-1 text-sm rounded"
                                            />
                                        </td>
                                        <td className="py-3 px-4">
                                            RS {(cartItem.product.price * cartItem.quantity).toFixed(2) || 'N/A'}
                                        </td>
                                        <td className="py-3 px-4">
                                            <button
                                                onClick={() => deleteProductFromCart(cartItem.id)}
                                                className="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                            >
                                                Remove
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                            </tbody>
                            <tfoot>
                            {cartProducts.length > 0 && (
                                <tr className="bg-gray-100 font-bold">
                                    <td colSpan="4" className="py-3 px-4 text-right">
                                        Grand Total:
                                    </td>
                                    <td className="py-3 px-4">
                                        RS {calculateGrandTotal()}
                                    </td>
                                    <td className="py-3 px-4">
                                        <button
                                            onClick={handleCheckout}
                                            className="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded"
                                        >
                                            Checkout
                                        </button>
                                    </td>
                                </tr>
                            )}
                            </tfoot>
                        </table>
                    </div>
                )}
            </div>
            <Footer />
        </div>
    );
};

export default CartView;
