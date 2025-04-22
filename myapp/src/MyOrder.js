import React from 'react';
import Navbar from './Navbar';
import Footer from './Footer';

const MyOrder = () => {
    const orders = [
        {
            id: 1,
            date: '2025-04-20',
            amount: 150.99,
            status: 'Delivered',
        },
        {
            id: 2,
            date: '2025-04-18',
            amount: 79.49,
            status: 'Processing',
        },
        {
            id: 3,
            date: '2025-04-15',
            amount: 220.00,
            status: 'Cancelled',
        },
    ];
    return (
        <>
            <Navbar/>
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
                    <div className="container col-md-8 col-12 text-center mt-5">
                        <h2 className="mb-4 mt-5 text-white">My Orders</h2>
                        <table className="table table-striped">
                            <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Order Amount</th>
                                <th>Order Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            {orders.map(order => (
                                <tr key={order.id}>
                                    <td>{order.date}</td>
                                    <td>${order.amount.toFixed(2)}</td>
                                    <td>
                <span className={`badge ${
                    order.status === 'Delivered' ? 'bg-success' :
                        order.status === 'Processing' ? 'bg-warning' :
                            'bg-danger'
                }`}>
                  {order.status}
                </span>
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <Footer/>
        </>
    )

}
export default MyOrder
