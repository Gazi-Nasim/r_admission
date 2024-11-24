# https://github.com/ageitgey/face_recognition/
# apt install -y python3-pip
# pip3 install cmake
# pip3 install dlib
# pip3 install face_recognition
import sys
import face_recognition
# import json

def load_image(image_path):
    try:
        return face_recognition.load_image_file(image_path)
    except FileNotFoundError:
        raise Exception(f"Image file '{image_path}' not found.")

def find_face_encodings(image, image_path):
    face_encodings = face_recognition.face_encodings(image)
    if not face_encodings:
        raise Exception(f"No face found in the image '{image_path}'.")
    return face_encodings

def calculate_similarity_using_distance(encoding1, encoding2):
    similarity = face_recognition.face_distance([encoding1], encoding2)
    return 1 - similarity[0]

def calculate_similarity_compare_faces(encoding1, encoding2):
    return face_recognition.compare_faces([encoding1], encoding2, 0.4)[0]

def main(image_path1, image_path2):
    try:
        # Load images
        image1 = load_image(image_path1)
        image2 = load_image(image_path2)

        # Find face encodings
        encoding1 = find_face_encodings(image1, image_path1)
        encoding2 = find_face_encodings(image2, image_path2)

        # Calculate face similarity using distance
        similarity_percentage = calculate_similarity_using_distance(encoding1[0], encoding2[0])
        print(f"{similarity_percentage * 100:.2f}")

        # Calculate face similarity using compare_faces
        # matched_status = calculate_similarity_compare_faces(encoding1[0], encoding2[0])

        # Prepare JSON output
        # output = {
            # "percentage": f"{similarity_percentage * 100:.2f}",
            # "status": bool(matched_status)
        # }

        # Print JSON output
        # print(json.dumps(output, indent=2))

    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python3 faced.py <image_path1> <image_path2>")
        sys.exit(1)

    main(sys.argv[1], sys.argv[2])
