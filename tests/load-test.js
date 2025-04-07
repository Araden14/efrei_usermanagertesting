import http from 'k6/http';
import { check, sleep } from 'k6';
import { textSummary } from "https://jslib.k6.io/k6-summary/0.0.1/index.js";
import { htmlReport } from "https://raw.githubusercontent.com/benc-uk/k6-reporter/main/dist/bundle.js";


export const options = {
  vus: 500,
  duration: '120s',
  thresholds: {
    http_req_duration: ['p(95)<800'],
    'http_req_failed': ['rate<0.01'],
    'checks': ['rate>0.99'],
  },
};

const BASE_URL = 'http://localhost:8000';

export default function () {
  const uniqueId = `${__VU}-${__ITER}`;
  const name = `TestUser_${uniqueId}`;
  const email = `testuser_${uniqueId}@example.com`;

  const payload = {
    name: name,
    email: email,
  };

  const res = http.post(`${BASE_URL}/api.php`, payload);

  check(res, {
    'status is 200': (r) => r.status === 200,
  });

  sleep(1);
}

export function handleSummary(data) {
  return {
      "report.html": htmlReport(data),
  };
}