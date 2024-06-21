export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Products {
    current_page: number;
    data: Product[];
    first_page_url: string;
    from: number;
    next_page_url: string;
    path: string;
    prev_page_url: string;
    to: number;
}

export interface Product {
    id: number;
    name: string;
    quantity: number;
    price: number;
    is_expired: number;
    created_at: string;
}

export interface Sale {
    id: number;
    product_id: number;
    quantity: number;
    date_purchased: string;
    created_at: string;
}

export interface Sale {
    id: number;
    name: string;
    quantity: number;
    price: number;
    is_expired: number;
    created_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    products: Products;
    sales: Sale[];
};
