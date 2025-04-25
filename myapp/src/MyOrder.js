import React, { useState, useEffect } from 'react';
import Navbar from './Navbar';
import Footer from './Footer';

const MyOrder = () => {
    const [orders, setOrders] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const formatTimestamp = (timestamp) => {
        const date = new Date(timestamp);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
        });
    };
    useEffect(() => {
        const fetchOrders = async () => {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/orders', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                        'Content-Type': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                setOrders(data.orders || []);
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchOrders();
    }, []);

    return (
        <>
            <Navbar />
            <div className="min-h-screen flex flex-col">
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
                    <div className="container col-md-8 col-12 text-center mt-5">
                        <h2 className="mb-4 mt-5 text-white">My Orders</h2>

                        {loading ? (
                            <p className="text-white">Loading...</p>
                        ) : error ? (
                            <p className="text-danger">{error}</p>
                        ) : orders.length === 0 ? (
                            <p className="text-white">No orders found.</p>
                        ) : (
                            <table className="table table-striped bg-white rounded">
                                <thead className="table-dark">
                                <tr>
                                    <th>Order Date</th>
                                    <th>Order Amount</th>
                                    <th>Order Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                {orders.map(order => {
                                    const rawStatus = order.status.toLowerCase();
                                    const displayStatus =
                                        rawStatus === 'completed' ? 'Delivered' :
                                            rawStatus === 'processing' ? 'Processing' :
                                                rawStatus === 'cancelled' ? 'Cancelled' :
                                                    'Pending';

                                    const badgeClass =
                                        rawStatus === 'completed' ? 'bg-success' :
                                            rawStatus === 'processing' ? 'bg-warning text-dark' :
                                                rawStatus === 'cancelled' ? 'bg-danger' :
                                                    'bg-secondary';

                                    return (
                                        <tr key={order.id}>
                                            <td>{formatTimestamp(order.created_at)}</td>
                                            <td>RS {order.total.toFixed(2)}</td>
                                            <td>
                                                    <span className={`badge ${badgeClass}`}>
                                                        {displayStatus}
                                                    </span>
                                            </td>
                                        </tr>
                                    );
                                })}
                                </tbody>
                            </table>
                        )}
                    </div>
                </div>
            </div>
            <Footer />
        </>
    );
};

export default MyOrder;
