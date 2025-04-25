import React from "react-dom"

const Service = () => {
    return (
        <>
            <div className="service mt-5">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-4 col-md-6">
                            <h2><i className="fas fa-shipping-fast "></i></h2>
                            <h2>fast delivery</h2>
                            <p>Medifast offers fast and reliable delivery, ensuring your medical supplies and healthcare
                                products reach you quickly and securely, right at your doorstep.</p>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <h2><i className="fa-solid fa-file-contract"></i></h2>
                            <h2>license of government</h2>
                            <p>Medifast is a health and wellness company that follows government rules. In 2012, it paid
                                a fine for false weight-loss claims. It follows laws to keep its business fair and
                                honest.</p>
                        </div>
                        <div className="col-md-6 col-lg-4">
                            <h2><i className="fa-solid fa-user-tie"></i></h2>
                            <h2>support 24/7</h2>
                            <p>It ensures that customers can get help anytime, day or night, for their queries, orders,
                                or any support they need.</p>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Service;
