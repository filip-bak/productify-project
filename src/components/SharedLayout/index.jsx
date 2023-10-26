import React from 'react';
import { Outlet } from 'react-router-dom';
import './SharedLayout.scss';
import Footer from './Footer';
import Header from './Header';

const SharedLayout = () => {
  return (
    <div className="wrapper">
      <Header />

      {/* <main className="main"> */}
      <Outlet />
      {/* </main> */}

      <Footer />
    </div>
  );
};

export default SharedLayout;
