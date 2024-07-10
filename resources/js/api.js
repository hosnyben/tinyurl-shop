import axios from 'axios'

const apiUrl = import.meta.env.VITE_API_URL;

const api = axios.create({
    baseURL: apiUrl,
});

api.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 404) {
            
        }
        return Promise.reject(error);
    }
);

// Index products
export function getProducts($params){
    return api.get('/products',{params: $params}).then(response => {
        return response.data
    });
}

// Show product
export function getProduct($uuid){
    return api.get(`/products/${$uuid}`).then(response => {
        return response.data
    });
}

// Create product
export function createProduct($data){
    return api.post('/products',$data).then(response => {
        return response.data
    });
}

// Update product
export function updateProduct($uuid, $data){
    return api.patch(`/products/${$uuid}`,$data).then(response => {
        return response.data
    });
}

// Delete product
export function deleteProduct($uuid){
    return api.delete(`/products/${$uuid}`).then(response => {
        return response.data
    });
}

// Get last viewed products
export function getLastViewedProducts(){
    return api.get('/last-viewed-products').then(response => {
        return response.data
    });
}

// Index categories
export function getCategories($page = 1){
    return api.get('/categories',{params: {page: $page}}).then(response => {
        return response.data
    });
}

// Show category
export function getCategory($uuid){
    return api.get(`/categories/${$uuid}`).then(response => {
        return response.data
    });
}

// Create category
export function createCategory($data){
    return api.post('/categories',$data).then(response => {
        return response.data
    });
}

// Update category
export function updateCategory($uuid, $data){
    return api.patch(`/categories/${$uuid}`,$data).then(response => {
        return response.data
    });
}

// Delete category
export function deleteCategory($uuid){
    return api.delete(`/categories/${$uuid}`).then(response => {
        return response.data
    });
}