import mongoose from "mongoose";
const { Schema } =
await mongoose.connect("mongodb://localhost:27017");

try {
    console.log("Connected to MongoDB");
} catch (error) {
    console.error("Error connecting to MongoDB:", error);
}
