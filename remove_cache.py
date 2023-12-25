import os, shutil

for dirPath, dirNames, fileNames in os.walk("."):
	for name in dirNames:
		if name == "__pycache__":
			shutil.rmtree(os.path.join(dirPath,name))