import './bootstrap';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/inertia-react';
import React from 'react';
import '../css/app.css';
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';

createInertiaApp({
  resolve: name => import(`./Pages/${name}`),
  setup({ el, App, props }) {
    createRoot(el).render(
        
    <App  {...props}  />
  
  );
  },
});
