import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    stages: [
        { duration: '30s', target: 50 },  // Naikkan ke 50 pengguna dalam masa 30 saat
        { duration: '1m', target: 50 },   // Kekalkan 50 pengguna selama 1 minit
        { duration: '10s', target: 0 },   // Turunkan bebanan secara beransur-ansur
    ],
};

export default function () {
    // Pastikan kau menukar alamat localhost/ngrok ini ke alamat sebenar pelayan staging kau
    const res = http.get('http://localhost:8080/login');
    
    // Pastikan pelayan membalas dengan status 200 OK
    check(res, { 'berjaya muat halaman login': (r) => r.status === 200 });
    
    sleep(1);
}