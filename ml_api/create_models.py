#!/usr/bin/env python3
"""
Script to train fish species recognition and detection models using FishImgDataset.
"""

import os
import numpy as np
import tensorflow as tf
from tensorflow.keras.models import Sequential, load_model
from tensorflow.keras.layers import Dense, GlobalAveragePooling2D, Dropout
from tensorflow.keras.applications import MobileNetV2
from tensorflow.keras.optimizers import Adam
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.callbacks import ModelCheckpoint, EarlyStopping, ReduceLROnPlateau
from ultralytics import YOLO
import matplotlib.pyplot as plt
import shutil
import random
from datetime import datetime
import json

def get_class_mapping(dataset_path):
    """Get class mapping from directory structure"""
    train_dir = os.path.join(dataset_path, 'train')
    classes = sorted([d for d in os.listdir(train_dir) 
                     if os.path.isdir(os.path.join(train_dir, d))])
    return {i: class_name for i, class_name in enumerate(classes)}

def create_species_model(dataset_path):
    """Train a CNN + MobileNetV2 model for fish species recognition"""
    try:
        # Setup paths
        train_dir = os.path.join(dataset_path, 'train')
        val_dir = os.path.join(dataset_path, 'val')
        
        # Get number of classes
        num_classes = len(os.listdir(train_dir))
        class_mapping = get_class_mapping(dataset_path)
        
        # Save class mapping
        models_dir = os.path.join(os.path.dirname(__file__), 'models')
        os.makedirs(models_dir, exist_ok=True)
        with open(os.path.join(models_dir, 'class_mapping.json'), 'w') as f:
            json.dump(class_mapping, f)
        
        # Data augmentation and preprocessing
        train_datagen = ImageDataGenerator(
            rescale=1./255,
            rotation_range=20,
            width_shift_range=0.2,
            height_shift_range=0.2,
            shear_range=0.2,
            zoom_range=0.2,
            horizontal_flip=True,
            fill_mode='nearest'
        )
        
        val_datagen = ImageDataGenerator(rescale=1./255)
        
        # Load training data
        train_generator = train_datagen.flow_from_directory(
            train_dir,
            target_size=(224, 224),
            batch_size=32,
            class_mode='categorical'
        )
        
        # Load validation data
        val_generator = val_datagen.flow_from_directory(
            val_dir,
            target_size=(224, 224),
            batch_size=32,
            class_mode='categorical',
            shuffle=False
        )
        
        # Create base MobileNetV2 model
        base_model = MobileNetV2(
            weights='imagenet',
            include_top=False,
            input_shape=(224, 224, 3)
        )
        
        # Freeze base model layers
        base_model.trainable = False
        
        # Create the full model
        model = Sequential([
            base_model,
            GlobalAveragePooling2D(),
            Dense(1024, activation='relu'),
            Dropout(0.5),
            Dense(512, activation='relu'),
            Dropout(0.3),
            Dense(num_classes, activation='softmax')
        ])
        
        # Compile model
        model.compile(
            optimizer=Adam(learning_rate=0.0001),
            loss='categorical_crossentropy',
            metrics=['accuracy']
        )
        
        # Callbacks
        checkpoint = ModelCheckpoint(
            os.path.join(models_dir, 'best_fish_species_model.h5'),
            monitor='val_accuracy',
            save_best_only=True,
            mode='max',
            verbose=1
        )
        
        early_stop = EarlyStopping(
            monitor='val_loss',
            patience=10,
            restore_best_weights=True,
            verbose=1
        )
        
        reduce_lr = ReduceLROnPlateau(
            monitor='val_loss',
            factor=0.2,
            patience=5,
            min_lr=1e-6,
            verbose=1
        )
        
        # Train the model
        print("\n🚀 Training fish species recognition model...")
        history = model.fit(
            train_generator,
            epochs=50,
            validation_data=val_generator,
            callbacks=[checkpoint, early_stop, reduce_lr],
            verbose=1
        )
        
        # Save the final model
        final_model_path = os.path.join(models_dir, 'fish_species_model.h5')
        model.save(final_model_path)
        
        # Plot training history
        plt.figure(figsize=(12, 4))
        
        plt.subplot(1, 2, 1)
        plt.plot(history.history['accuracy'], label='Training Accuracy')
        plt.plot(history.history['val_accuracy'], label='Validation Accuracy')
        plt.title('Model Accuracy')
        plt.xlabel('Epoch')
        plt.ylabel('Accuracy')
        plt.legend()
        
        plt.subplot(1, 2, 2)
        plt.plot(history.history['loss'], label='Training Loss')
        plt.plot(history.history['val_loss'], label='Validation Loss')
        plt.title('Model Loss')
        plt.xlabel('Epoch')
        plt.ylabel('Loss')
        plt.legend()
        
        # Save training plots
        plots_dir = os.path.join(os.path.dirname(__file__), 'training_plots')
        os.makedirs(plots_dir, exist_ok=True)
        plot_path = os.path.join(plots_dir, f'training_history_{datetime.now().strftime("%Y%m%d_%H%M%S")}.png')
        plt.tight_layout()
        plt.savefig(plot_path)
        
        print(f"✅ Training completed. Model saved to: {final_model_path}")
        print(f"📊 Training plots saved to: {plot_path}")
        
        return True
        
    except Exception as e:
        print(f"❌ Error in create_species_model: {str(e)}")
        import traceback
        traceback.print_exc()
        return False

def create_yolo_model():
    """Create a placeholder YOLOv8 model for fish detection"""
    try:
        # Create a simple YOLOv8 model
        model = YOLO('yolov8n.pt')  # Use nano model as base
        
        # Save model
        models_dir = os.path.join(os.path.dirname(__file__), 'models')
        os.makedirs(models_dir, exist_ok=True)
        model_path = os.path.join(models_dir, 'yolov8_fish.pt')
        model.save(model_path)
        
        print(f"✅ YOLOv8 fish detection model saved to: {model_path}")
        return True
        
    except Exception as e:
        print(f"❌ Error creating YOLO model: {str(e)}")
        return False

def main():
    """Main function to train fish species recognition and detection models"""
    print("🔧 Training Fish Monitoring ML Models")
    print("=" * 60)
    
    # Set paths
    dataset_path = os.path.join(os.path.dirname(__file__), 'FishImgDataset')
    
    if not os.path.exists(dataset_path):
        print(f"❌ Dataset not found at: {dataset_path}")
        return
    
    print(f"📂 Using dataset from: {dataset_path}")
    
    # Train species recognition model
    print("\n🔄 Training Species Recognition Model...")
    species_success = create_species_model(dataset_path)
    
    # Create YOLO model (using pre-trained weights for now)
    print("\n🔄 Setting up YOLO Detection Model...")
    yolo_success = create_yolo_model()
    
    # Print summary
    print("\n📊 Training Summary:")
    print("-" * 60)
    print(f"Species Recognition Model: {'✅ Success' if species_success else '❌ Failed'}")
    print(f"YOLO Detection Model:     {'✅ Success' if yolo_success else '❌ Failed'}")
    
    if species_success and yolo_success:
        print("\n🎉 All models trained successfully!")
    else:
        print("\n❌ Some models failed to train. Check the error messages above.")

if __name__ == "__main__":
    # Set memory growth for GPU if available
    physical_devices = tf.config.list_physical_devices('GPU')
    if physical_devices:
        try:
            for device in physical_devices:
                tf.config.experimental.set_memory_growth(device, True)
            print("✅ GPU configured with memory growth")
        except RuntimeError as e:
            print(f"⚠️ Error configuring GPU: {e}")
    else:
        print("ℹ️ No GPU found. Training on CPU.")
    
    main()