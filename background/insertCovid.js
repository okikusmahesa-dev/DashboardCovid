import axios from 'axios';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

dotenv.config();

async function insertCovidData() {
  try {
    const date = process.env.COVID_DATE;

    // Fetch data dari API
    const response = await axios.get(`https://covid-api.com/api/reports?date=${date}`);

    // Check if data exists
    if (!response.data.data || response.data.data.length === 0) {
      console.log('No data available for this request');
      return;
    }

    const covidDataArray = response.data.data;

    // Koneksi ke DB
    const connection = await mysql.createConnection({
      host: '127.0.0.1',
      user: 'root',
      password: 'password',
      database: 'laravel',
      port: 3306
    });

    // Create table jika belum ada
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS covid_dailies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        country VARCHAR(100),
        province VARCHAR(100),
        iso VARCHAR(10),
        lat DOUBLE,
        longitude DOUBLE,
        date DATE,
        confirmed BIGINT,
        deaths BIGINT,
        recovered BIGINT,
        active BIGINT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )
    `);

    // Loop seluruh data dan insert
    for (const data of covidDataArray) {
      const covidDate = data.date;
      const confirmed = data.confirmed;
      const deaths = data.deaths;
      const recovered = data.recovered;
      const active = data.active;

      const country = data.region.name;
      const province = data.region.province;
      const iso = data.region.iso;
      const lat = data.region.lat;
      const long = data.region.long;

      const [rows] = await connection.execute(
        'INSERT INTO covid_dailies (country, province, iso, lat, longitude, date, confirmed, deaths, recovered, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [country, province, iso, lat, long, covidDate, confirmed, deaths, recovered, active]
      );

      console.log(`Data inserted for ${country} - ${province}:`, rows);
    }

    await connection.end();
    console.log('All data inserted successfully.');

  } catch (error) {
    console.error('Error inserting covid data:', error);
  }
}

insertCovidData();
